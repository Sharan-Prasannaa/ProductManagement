<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function index(){
        $orders = Order::with('user','OrderItems')->get();
        return view('orders.index', compact('orders'));
    }
    public function show($orderId)
    {
        $order = Order::with('orderItems.product')->findOrFail($orderId); // Include order items with product details
        return view('orders.show', compact('order'));
    }
   // Filter orders by status
   public function filterByStatus(Request $request)
   {
       $status = $request->status;
       if(!$status){
        $orders = Order::with('user')->get();
       }
       else {
        $orders = Order::where('status', $status)->with('user')->get(); // Apply filter by status
        }
       return view('orders.index', compact('orders'));
   }
    // Update order status
    public function updateStatus(Request $request, $orderId)
    {
        $request->validate([
            'status' => 'required|in:pending,completed,cancelled',
        ]);

        $order = Order::findOrFail($orderId);
        $order->update([
            'status' => $request->status,
        ]);

        return redirect()->route('orders.show', $orderId)->with('status', 'Order status updated successfully!');
    }
}
