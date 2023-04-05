<?php

namespace App\Http\Controllers\User;

use App\Models\Order;
use App\Models\Service;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Generalsetting;

class UserOrderController extends Controller
{
    public function newOrder()
    {
        $categories = Category::with('services')->where('status', 1)->get();
        return view('user.order.new_order',compact('categories'));
    }

    public function categoryService()
    {
        $services = Service::where('category_id', request('category_id'))->where('status',1)->get();
        return view('user.order.category_service',compact('services'));
    }

    public function getServiceDetails()
    {
        $service = Service::where('status',1)->find(request('service_id'));
        return response()->json($service);
    }

    public function confirmOrder(Request $request)
    {
       $request->validate([
            'category_id' => 'required|integer',
            'service_id'  => 'required|integer',
            'link'        => 'required|url',
            'qty'         => 'required|integer',
       ],
       [
            'category_id.required' => 'Please select a category',
            'service_id.required'  => 'Please select a service',
       ]);

       $user    = auth()->user(); 
       $service = Service::findOrFail($request->service_id);
       $price   = round(($request->qty * $service->price) / 1000, 2);

       if ($user->balance < $price) return back()->with('error', "Insufficient balance.");
       if ($service->min_amount > $request->qty) return back()->with('error', 'Minimum order quantity is '.$service->min_amount);
       if ($service->max_amount < $request->qty) return back()->with('error', 'Maximum order quantity is '.$service->max_amount);

       $order = new Order();
       $order->category_id  = $request->category_id;
       $order->service_id   = $request->service_id;
       $order->user_id      = $user->id;
       $order->link         = $request->link;
       $order->qty          = $request->qty;
       $order->status       = 'processing';
       $order->price        = $price;

        if ($service->provider) {
          $provider  = $service->provider;
          $orderData = ['service'   => $service->service_id, 'link' => $request->link, 'quantity' => $request->qty];
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
        $trx->details = 'Placing order for '.$service->title.' #QTY : '.$request->qty;
        $trx->save();

        @mailSend('order_place', [
            'order'   => $order->id,
            'service' => $service->title,
            'price'   => $price,
            'qty'     => $request->qty,
            'curr'    => Generalsetting::value('curr_code'),
            'trnx'    => $trx->trnx,
            'date_time' => date('Y-m-d H:i:s'),
        ],$user);

        return back()->with('success', 'Your order has been placed successfully');
    }

    public function newMassOrder()
    {
        return view('user.order.new_mass_order');
    }

    public function confirmMassOrder(Request $request)
    {
       $request->validate([
         'order' => 'required|array',
         'order.*' => 'required',
         'order.*.qty' => 'required|integer',
         'order.*.link' => 'required|url',
         'order.*.id' => 'required|integer',
       ]);

       if(!isset($request->only('order')['order'])) return back()->with('error', "Invalid order.");
      
       $massOrders = $request->only('order')['order'];
       foreach ($massOrders as $order) {
            $user    = auth()->user(); 
            $service = Service::findOrFail($order['id']);
            $price   = round(($order['qty'] * $service->price) / 1000, 2);

            if ($user->balance < $price) return back()->with('error', "Insufficient balance.");
            if ($service->min_amount > $order['qty']) return back()->with('error', 'Minimum order quantity is '.$service->min_amount);
            if ($service->max_amount < $order['qty']) return back()->with('error', 'Maximum order quantity is '.$service->max_amount);
    
            $newOder = new Order();
            $newOder->category_id  = $service->category_id;
            $newOder->service_id   = $service->id;
            $newOder->user_id      = $user->id;
            $newOder->link         = $order['link'];
            $newOder->qty          = $order['qty'];
            $newOder->status       = 'processing';
            $newOder->price        = $price;

            if ($service->provider) {
               
                $provider  = $service->provider;
                $orderData = ['service' => $service->service_id, 'link' => $order['link'], 'quantity' => $order['qty']];
                $apiOrder  = (object) apiCall($provider,'add',$orderData);
               
                if($apiOrder->error) $newOder->api_response = $apiOrder->error;
                else{$newOder->api_response = "Order ID : $apiOrder->order"; $newOder->api_order_id = $apiOrder->order;} 
            }

            $newOder->save();
            
            $user->balance -= $price;
            $user->save();

            $txn = str_rand();

            $trx          = new Transaction();
            $trx->trnx    = $txn;
            $trx->user_id = $user->id;
            $trx->charge  = 0;
            $trx->amount  = $price;
            $trx->remark  = 'order_placed';
            $trx->type    = '-';
            $trx->details = 'Placing order for '.$service->title.' #QTY : '.$order['qty'];
            $trx->save();

        }

        @mailSend('mass_order_place', [
            'order'   => count($massOrders),
            'trnx'    => $trx->trnx,
            'date_time' => date('Y-m-d H:i:s'),
        ],$user);

        return back()->with('success', 'Your order has been placed successfully');
      
    }

    public function orderHistory ()
    {
        $orders = Order::where('user_id', auth()->user()->id)
        ->when(request('status'), function($query){
            return $query->where('status', request('status'));
        })
        ->paginate(15);    
        return view('user.order.order_history',compact('orders'));
    }

    public function getOrders()
    {
        $orders = Order::where('user_id', auth()->id())
        ->where('id',request('order'))
        ->orWhere('status', 'LIKE', "%".request('order')."%")
        ->orWhere(function($query){
            $query->whereHas('service', function($q){
                $q->where('title','LIKE' ,"%".request('order')."%");
            });
        })
        ->get();    
        return view('user.order.get_orders',compact('orders'));
    }

    public function services()
    {
        $services = Service::when(request('category'), function($query){
            return $query->where('category_id', request('category'));
        })
       
        ->latest()
        ->paginate(15);   
        
        $categories = Category::where('status',1)->get();
        return view('user.services',compact('services','categories'));
    }
    public function getServices()
    {
        $services = Service::when(request('name'), function($query){
            return $query->where('id',request('name'))
                ->orWhere('title', "like","%".request('name')."%");
        })
        ->latest()
        ->paginate(15);   
        
        return view('user.get_services',compact('services'));
    }
}