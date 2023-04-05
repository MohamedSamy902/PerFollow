<?php
namespace  App\Http\Controllers\User;

use App\Models\User;
use App\Models\Deposit;
use App\Models\Currency;
use App\Models\Referral;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\PaymentGateway;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class DepositController extends Controller {


    public function index()
    {
        Session::forget('deposit_data');
        return view('user.deposit.index',[
            'currencies' => Currency::whereStatus(1)->get(),
        ]);
    }

    public function methods(Request $request)
    {
        $methods = PaymentGateway::whereJsonContains('currency_id',$request->currency)->where('status',1)->get();
        if($methods->isEmpty()) return response('empty');
        return response($methods);
    }

    public function dipositHistory()
    {
        $deposits = Deposit::where('user_id',auth()->id())->latest()->paginate(15);
        return view('user.deposit.history',[
            'deposits' => $deposits
        ]);
    }

    public function depositSubmit(Request $request)
    {
        $request->validate(['amount'=>'required|gt:0','gateway'=>'required']);
        $currency = Currency::findOrFail($request->currency);
        $gateway = PaymentGateway::findOrFail($request->gateway);
        $charge = null;
     
        if($gateway->type == 'manual'){
            $charge = $gateway->fixed_charge + (($request->amount * $gateway->percent_charge)/100);
            $totalAmount =  $request->amount + $charge; 
            $request['amount'] = $totalAmount;
            $request['charge'] = $charge;
        }

        $input = $request->merge(['keyword' => $gateway->keyword])->except('_token');
        Session::put('deposit_data',$input);
        return view('user.deposit.payment',[
            'gateway'      => $gateway,
            'deposit_data' => Session::get('deposit_data'),
            'currency'    => $currency,
            'charge'  => $charge
        ]);
    }

    public function balanceUpdate($user,$deposit_data)
    {
        $currency = Currency::findOrFail($deposit_data['currency']);
        $user = auth()->user();
        $finalAmount = amountConv($deposit_data['amount'], $currency);
        $user->balance += $finalAmount;
        $user->update();

        $trnx              = new Transaction();
        $trnx->trnx        = str_rand();
        $trnx->user_id     = $user->id;
        $trnx->amount      = $deposit_data['amount'];
        $trnx->charge      = 0;
        $trnx->remark      = 'deposit';
        $trnx->type        = '+';
        $trnx->details     = translate('Deposit balance to wallet : '). $deposit_data['curr_code'];
        $trnx->save();

        //referral bonus
        try {
            $refferal = Referral::first();
            if($refferal->status == 1 && $user->referred_by != null){
                $referrer = User::find($user->referred_by);
                if($referrer->referBonusCount() < $refferal->bonus_count){
                    $this->referralOperation($refferal,$referrer,$user,$finalAmount);
                }
            }
        } catch (\Throwable $th) {
           
        }
        
    }

    public function depositPayment(Request $request)
    {
        $request_data = $request;
        $currency = Currency::findOrFail($request->currency);
        $deposit_data = Session::get('deposit_data');
    
        $service =  str_replace('User','',__NAMESPACE__). 'Gateway'. '\\'. ucwords($deposit_data['keyword']);
        $deposit = $service::initiate($request_data,$deposit_data,'deposit');

        if($deposit['status'] == 1 && in_array($deposit_data['keyword'],['paytm','razorpay'])){
            return view($deposit['view'],$deposit['prams']);
        }

        if($deposit['status'] == 1 && isset($deposit['url'])){
            return redirect($deposit['url']);
        }

        try {
            if($deposit['status'] == 1){
             
                $user = auth()->user();
                $data = new Deposit();
                $data->user_id      = $user->id;
                $data->amount       = $deposit_data['amount'];
                $data->default_curr_amount = amountConv($deposit_data['amount'], $currency);
                $data->method       = $deposit_data['gateway'];
                $data->currency_id  = $currency->id;
                $data->status       = $request->type == 'manual' ? 'pending': 'completed';
                $data->txn_id       = $deposit['txn_id'];
                $data->trx_details  = $request->trx_details;
                $data->charge       = $deposit_data['charge'] ?? null;
                $data->save();
              
                if($request->type != 'manual'){
                    $this->balanceUpdate($user,$deposit_data);
                    $msg = __('Your balance added successfully');
                }else{
                    $msg = __('Your deposit request is taken wait for the admin approval.');
                }
             
                Session::forget(['deposit_data','currency','invoice']);
                return redirect(route('user.deposit.index'))->with('success',$msg);
            }
        } catch (\Throwable $th) {
            return redirect(route('user.deposit.index'))->with('error',__('Somthing went wrong please try again'));
        }
        return redirect(route('user.deposit.index'))->with('error',$deposit['message']);
    }


    public function notifyOperation($deposit)
    {
        $deposit_data = Session::get('deposit_data');
        try {
             $currency = Currency::findOrFail($deposit_data['currency']);
            if($deposit['status'] == 1 && $deposit['txn_id']){
                $user = auth()->user();
               
                $data = new Deposit();

                $data->user_id  = $user->id;
                $data->currency_id  = session('currency')->id;
                $data->user_type  = 1;
                $data->amount   = $deposit_data['amount'];
                $data->method   = $deposit_data['gateway'];
                $data->currency_id  = currency();
                $data->default_curr_amount = amountConv($deposit_data['amount'], $currency);
                $data->status  = 'completed';
                $data->txn_id  = $deposit['txn_id'];
                $data->save();

                $this->balanceUpdate($user,$deposit_data);
                
                Session::forget('deposit_data');
                return redirect(route('user.deposit.index'))->with('success','Your balance added successfully');
            }
        } catch (\Throwable $th) {
            return redirect(route('user.deposit.index'))->with('error',__('Somthing want wront please try again'));
        }
    }

    public function referralOperation($refferal,$referrer,$user,$amount)
    {

      if($referrer && $refferal->status) {
        if($refferal->type == 'deposit'){ 
            $bonus = $amount * ($refferal->bonus_amount/100);
            $referrer->balance += $bonus;
            $referrer->update();

            $trnx              = new Transaction();
            $trnx->trnx        = str_rand();
            $trnx->user_id     = $referrer->id;
            $trnx->bonus_from  = $user->id;
            $trnx->amount      = $bonus;
            $trnx->charge      = 0;
            $trnx->remark      = 'deposit_referral_bonus';
            $trnx->type        = '+';
            $trnx->details     = __('Referral bonus from user deposit');
            $trnx->save();
        } 
      }
      return true;
    }
}