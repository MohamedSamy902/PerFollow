<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Service;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\Generalsetting;
use Illuminate\Support\Facades\Validator;

class HandleApiV1Controller extends Controller
{
    function handleV1(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'key' => 'required|string',
            'action' => 'required|string',
        ]);
        if ($validator->fails()) return response()->json(['errors' => $validator->errors()], 422);
      
        $gs = Generalsetting::first();
        $action = strtolower($request->action);
        if (!in_array($action, ['add','orders','services','balance','status'])) {
            return response()->json(['errors' => ['message' => "Action not found"]], 404);
        }
        $actionStatus = $gs->api_actions[$action];
        if($actionStatus == 0) return response()->json(['errors' => ['message' => "This action is temporarily not in service."]], 403);
        
        $user = User::where('api_key', $request->key)->first();
        if (!$user) return response()->json(['errors' => ['message' => "Invalid API key"]], 404);
        if ($user->status == 0) return response()->json(['errors' => ['message' => "This user has been banned"]], 403);
        
        if ($action == 'balance')       return $this->getBalance($user,$gs->curr_code);
        elseif ($action == 'services')  return $this->getServices();
        elseif ($action == 'add')       return $this->placeOrder($user,$request);
        elseif ($action == 'status')    return $this->getStatus($user,$request,$gs->curr_code);
        elseif ($action == 'orders')    return $this->getOrders($user);
    }


    public function getBalance($user,$curr)
    {
        return response()->json([
            'status' => 'success',
            'balance' => round($user->balance,2),
            'currency' => $curr,
        ],200);
        
    }

    public function getServices()
    {
        $services = Service::where('status', 1)->get();
        $data = [];
        foreach ($services as $k =>  $item) {
            $res['service']  = $item->id;
            $res['name']     = $item->title;
            $res['category'] = $item->category ? $item->category->name : null;
            $res['rate']     = round($item->price,3);
            $res['min']      = $item->min_amount;
            $res['max']      = $item->max_amount;
            $data[$k] = $res;
        }
        return response()->json($data,200);
    }

    public function placeOrder($user,$request)
    {
        $validator = Validator::make($request->all(), [
            'service' => 'required',
            'link' => 'required',
            'quantity' => 'required|integer'
        ]);
 
       if ($validator->fails()) return response()->json(['errors' => $validator->errors()], 422);
        
       $service = Service::find($request->service);
       if (!$service)  return response()->json(['errors' => ['message' => "Service not found"]], 404);
    
       $price   = round(($request->quantity * $service->price) / 1000, 2);
       if ($user->balance < $price) return response()->json(['error', ['message' => "Insufficient balance."]], 422);
       if ($service->min_amount > $request->quantity) return response()->json(['errors'=> ['message'=>'Minimum order quantity is :'.$service->min_amount]],422);
       if ($service->max_amount < $request->quantity) return response()->json(['errors'=> ['message'=>'Maximum order quantity is :'.$service->max_amount]],422);

       $order = new Order();
       $order->category_id  = $service->category_id;
       $order->service_id   = $service->id;
       $order->user_id      = $user->id;
       $order->link         = $request->link;
       $order->qty          = $request->quantity;
       $order->status       = 'processing';
       $order->price        = $price;

       if ($service->provider) {
          $provider  = $service->provider;
          $orderData = ['service'   => $service->service_id, 'link' => $request->link, 'quantity' => $request->quantity];
          $apiOrder  = (object) apiCall($provider,'add',$orderData);
          if($apiOrder->error) $order->api_response = $apiOrder->error; 
          else{$order->api_response = "Order ID : $apiOrder->order"; $order->api_order_id = $apiOrder->order;} 
        }

        $order->save();
        
        $user->balance -= $price;
        $user->save();

        $trx          = new Transaction();
        $trx->trnx    = str_rand();
        $trx->user_id = $user->id;
        $trx->charge  = 0;
        $trx->amount  = $price;
        $trx->remark  = 'order_placed';
        $trx->type    = '-';
        $trx->details = 'Placing order for '.$service->title.' #QTY : '.$request->quantity;
        $trx->save();

        try {
            @mailSend('order_place', [
                'order'     => $order->id,
                'service'   => $service->title,
                'price'     => $price,
                'qty'       => $request->quantity,
                'curr'      => Generalsetting::value('curr_code'),
                'trnx'      => $trx->trnx,
                'date_time' => date('Y-m-d H:i:s'),
            ],$user);
        } catch (\Throwable $th) {
           
        }

        return response()->json(['status' => 'success', 'order_id' => $order->id], 200);
    }

    public function getStatus($user,$request,$curr)
    {
        $validator = Validator::make($request->all(), ['order' => 'required']);
        if ($validator->fails()) return response()->json(['errors' => $validator->errors()], 422);

        $order = Order::where('id', $request->order)->where('user_id', $user->id)->first();
        if (!$order) return response()->json(['errors' => ['message' => "Order not found"]], 404);
        
        return response()->json([
           'status'       => $order->status,
           'charge'       => $order->service ? round($order->service->price,3) : 0,
           'start_count'  => $order->start_counter,
           'remains'      => $order->remains,
           'currency'     => $curr,
        ], 200);
    }

    public function getOrders($user)
    {
        $orders = Order::where('user_id', $user->id)->get();
        
        $data = [];
        foreach ($orders as $k => $item) {
            $res['order']    = $item->id;
            $res['status']   = $item->status;
            $res['charge']   = $item->service ? round($item->service->price,3) : 0;
            $res['start_count']  = $item->start_counter;
            $res['remains']      = $item->remains;
            $data[$k] = $res;
        }
        return response()->json($data,200);
       
    }
}
