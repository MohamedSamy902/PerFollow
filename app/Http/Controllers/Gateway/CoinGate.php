<?php

namespace App\Http\Controllers\Gateway;
use App\Http\Controllers\User\DepositController;
use App\Models\Generalsetting;
use App\Models\PaymentGateway;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class Coingate {
    public static function initiate($request,$payment_data,$type)
    {

        $status = 0;
        $message = '';
        $url     = '';


        $gs =  Generalsetting::findOrFail(1);
        $item_number = Str::random(4).time();
        $blockchain    = PaymentGateway::whereKeyword('coingate')->first();
        $blockchain= $blockchain->convertAutoData();
        $coingateAuth = $blockchain['secret_string'];
        $item_name = $gs->title." Invest";

        $cancel_url = '';
        switch ($type) {
            case 'deposit':
                Session::put('type',$type);
                $cancel_url = route('user.deposit.submit');
                break;
            
            default:
                # code...
                break;
        }

     
        $my_callback_url = route('notify.coingate');
        $currency = session('currency')->code;
            \CoinGate\CoinGate::config(array(
                'environment'               => 'sandbox', // sandbox OR live
                'auth_token'                => $coingateAuth
            ));

     
            $post_params = array(
                'order_id'          => $item_number,
                'price_amount'      => $payment_data['amount'],
                'price_currency'    => $currency,
                'receive_currency'  => $currency,
                'callback_url'      => 'https://webhook.site/f828598b-c792-4a7e-8877-0b8d86b3805e',
                'cancel_url'        => $cancel_url,
                'success_url'       => $cancel_url,
                'title'             => $item_name,
                'description'       => 'Deposit'
            );
       
            $coinGate = \CoinGate\Merchant\Order::create($post_params);
            if ($coinGate)
            {
                $status = 1;
                $url = $coinGate->payment_url;
            }
            return ['status' => $status , 'message' => $message , 'url' => $url];
    }


    
    public function notify(Request $request){

        $status = 0;
        $message = '';
        $txn_id = '';
      if($request->status == 'paid'){
        $status = 1;
        $txn_id = $request->token;
      }else{
        $message = __('Payment Field');
      }

      switch (Session::get('type')) {
        case 'deposit':
            return DepositController::notifyOperation(['message' => $message , 'status' => $status , 'txn_id' => $txn_id]) ;
            break;
        default:
        break;
        }
    }
}