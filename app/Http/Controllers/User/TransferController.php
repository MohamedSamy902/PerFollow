<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\Generalsetting;
use App\Http\Controllers\Controller;

class TransferController extends Controller
{
    public function checkReceiver(Request $request){
        $receiver['data'] = User::where('email',$request->receiver)->orWhere('username',$request->receiver)->first();
        $user = auth()->user(); 
        if(@$receiver['data'] && $user->email == @$receiver['data']->email || $user->username == @$receiver['data']->username){
            return response()->json(['self'=>__('Can\'t transfer or request in self wallet.')]);
        }
        return response($receiver);
    }

    public function transferForm()
    {
        $gs = Generalsetting::first();
        if($gs->trans_status == 0) return back()->with('error','Balance Transfer is currently not available');
        return view('user.transfer_balance');
    }

    public function submitTransfer(Request $request)
    {
        $request->validate([
            'receiver'  => 'required',
            'amount'    => 'required|numeric|gt:0' 
        ]);
        
        $gs = Generalsetting::first();
        if($gs->trans_status == 0) return back()->with('error','Balance Transfer is currently not available');
      
        if(auth()->user()->email == $request->receiver || auth()->user()->username == $request->receiver) return back()->with('error','Can\'t transfer to your own wallet');
        
        $receiver = User::where('email',$request->receiver)->orWhere('username',$request->receiver)->first();
        if(!$receiver) return back()->with('error','Receiver not found');
        

        if($gs->min_trans  > $request->amount || $gs->max_trans < $request->amount){
            return back()->with('error','Please follow the limit');
        }

        $finalCharge = round(chargeCalc($request->amount),2);
        $finalAmount =  round($request->amount + $finalCharge,2);
 
        if(auth()->user()->balance < $finalAmount) return back()->with('error','Insufficient balance.');
        
        auth()->user()->balance -= $finalAmount;
        auth()->user()->update();

        $trnx              = new Transaction();
        $trnx->trnx        = str_rand();
        $trnx->user_id     = auth()->id();
        $trnx->amount      = $request->amount;
        $trnx->charge      = $finalCharge;
        $trnx->remark      = 'transfer_balance';
        $trnx->type        = '-';
        $trnx->details     = trans('Transfer money to '). $receiver->email;
        $trnx->save();

        $receiver->balance += $request->amount;
        $receiver->update();

        $receiverTrnx              = new Transaction();
        $receiverTrnx->trnx        = $trnx->trnx;
        $receiverTrnx->user_id     = $receiver->id;
        $receiverTrnx->amount      = $request->amount;
        $receiverTrnx->charge      = 0;
        $receiverTrnx->remark      = 'transfer_balance';
        $receiverTrnx->type        = '+';
        $receiverTrnx->details     = trans('Received money from '). auth()->user()->email;
        $receiverTrnx->save();

        //to sender
        @mailSend('transfer_money',['trnx'=>$trnx->trnx,'amount'=> numFormat($request->amount,2),'curr'=>$gs->curr_code,'charge'=> numFormat($finalCharge),'after_balance'=> numFormat(auth()->user()->balance,3),'trans_to'=> $receiver->email,'date_time'=> dateFormat($trnx->created_at)],auth()->user());

        //to receiver
        @mailSend('received_money',['trnx'=>$trnx->trnx,'amount'=> numFormat($request->amount,3),'curr'=>$gs->curr_code,'charge'=> 0,'after_balance'=> numFormat($receiver->balance,2),'trans_from'=> auth()->user()->email,'date_time'=> dateFormat($trnx->created_at)],$receiver);
        
        return back()->with('success','Balance has been transferred successfully');

    }

    public function transferHistory()
    {
        $transfers = Transaction::where('user_id',auth()->id())->where('remark','transfer_money')->latest()->paginate(15);
        return view('user.transfer_history',compact('transfers'));
    }
}
