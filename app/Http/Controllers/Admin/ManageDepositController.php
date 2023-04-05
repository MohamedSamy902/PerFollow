<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Wallet;
use App\Models\Deposit;
use App\Models\Invoice;
use App\Models\Referral;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\Generalsetting;
use App\Http\Controllers\Controller;

class ManageDepositController extends Controller
{
    public function deposits()
    {
        $search = request('search');
        $status = request('status');
        $deposits = Deposit::when($status,function($q) use($status){
            return $q->where('status',$status);
        })
        ->when($search,function($q) use($search){
            return $q->where('txn_id','like',"%$search%");
        })
        ->latest()->paginate(15);
        return view('admin.deposit.index',compact('deposits','search'));
    }

    public function approve(Request $request)
    {
        $deposit = Deposit::findOrFail($request->id);
        $deposit->status = 'completed';
        $deposit->save();
        $user = User::findOrFail($deposit->user_id);

        $gs = Generalsetting::first();

        $user->balance += $deposit->default_curr_amount;
        $user->save();

        $trnx              = new Transaction();
        $trnx->trnx        = str_rand();
        $trnx->user_id     = $user->id;
        $trnx->amount      = $deposit->default_curr_amount;
        $trnx->charge      = amountConv($deposit->charge,$deposit->currency);
        $trnx->remark      = 'deposit';
        $trnx->type        = '+';
        $trnx->details     = trans('Approve deposit');
        $trnx->save();

         //referral bonus
         try {
            $refferal = Referral::first();
            if($refferal->status == 1 && $user->referred_by != null){
                $referrer = User::find($user->referred_by);
                if($referrer->referBonusCount() < $refferal->bonus_count){
                    $this->referralOperation($refferal,$referrer,$user,$deposit->default_curr_amount);
                }
            }
        } catch (\Throwable $th) {
           
        }

        @mailSend('deposit_approve',[
            'amount' => round($deposit->default_curr_amount,2),
            'curr'   => $gs->curr_code,
            'trnx'   => $trnx->trnx,
            'method' => $deposit->gateway->name,
            'charge' => round($deposit->charge,2),
            'new_balance' => round($user->balance,2),
            'data_time' => dateFormat($trnx->created_at)
        ],$user);

        return back()->with('success','Deposit has been approved');

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

    public function reject(Request $request)
    {
        $request->validate0([
            'id' => 'required',
            'reject_reason' => 'required'
        ]);

        $deposit = Deposit::findOrFail($request->id);
        $deposit->status = 'rejected';
        $deposit->reject_reason = $request->reject_reason;
        $deposit->save();
    
        $user = User::findOrFail($deposit->user_id);

        @mailSend('deposit_reject',[
            'amount' => amount($deposit->amount,$deposit->currency->type,2),
            'curr'   => $deposit->currency->code,
            'method' => $deposit->gateway->name,
            'charge' => amount($deposit->charge,$deposit->currency->type,2),
            'reject_reason' => $request->reject_reason,
            'data_time' => dateFormat(now())
        ],$user);

        return back()->with('success','Deposit has been rejected');
    }
}
