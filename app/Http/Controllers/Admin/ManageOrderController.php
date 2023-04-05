<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ManageOrderController extends Controller
{
    public function allOrders()
    {
        $orders = Order::when(request('status'),function($query){
            if(request('status') != 'all') return $query->where('status',request('status'));
        })
        ->when((request('field') && request('search')),function($query){
            if(request('field') == 'link') return $query->where('link',request('search'));
            return $query->where(request('field'),request('search'));
        })
        ->with('service','user')
        ->paginate(15);
        return view('admin.orders.all', compact('orders'));
    }

    public function editOrder($id)
    {
        $order = Order::findOrFail($id);
        return view('admin.orders.edit', compact('order'));
    }

    public function updateOrder(Request $request,$id)
    {
        $request->validate([
            'start_counter' => 'integer|gt:0',
            'remains'       => 'integer|gt:0',
        ]);

        $order = Order::findOrFail($id);
        $order->start_counter = $request->start_counter;
        $order->remains       = $request->remains;
        $order->status        = $request->status;
        $order->link          = $request->link;
        $order->save();

        return back()->with('success', 'Order updated successfully.');
    }

    public function removeOrder($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();
        return back()->with('success', 'Order removed successfully.');
    }

    public function multiAction(Request $request)
    {
        $request->validate(['action' => 'required|in:1,2','orders' => 'required|array','orders.*' => 'required']);

        if($request->action == 1){
            Order::whereIn('id',$request->orders)->delete();
            return back()->with('success', 'Orders removed successfully.');
        }
        elseif($request->action == 2){
            Order::whereIn('id',$request->orders)->update(['status' => $request->status]);
            return back()->with('success', 'Orders status changed to '.$request->status.' successfully.');
        }
    }
   
}
