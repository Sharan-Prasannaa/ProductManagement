<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;

class OrderItemController extends Controller
{
    public function showProducts()
    {
        $products = Product::all();
        return view('orders.show-products', compact('products'));
    }
    public function addTocart(Request $request,$productId){
        $product=Product::findOrFail($productId);
        $cart=session()->get('cart',[]); //session acts as temporary cart
        if(isset($cart[$productId])) {
            $cart[$productId]['quantity']++;
        } else {
            $cart[$productId] = [
                "product_id" => $productId,
                "name" => $product->name,
                "price" => $product->price,
                "quantity" => 1
            ];
        }
        session()->put('cart',$cart);
        return redirect()->route('orders.cart')->with('status', 'Product added to cart!');

    }
    public function showCart(){
        $cart=session()->get('cart',[]);
        $totalPrice = 0;
        foreach ($cart as $item) {
            $totalPrice += $item['quantity'] * $item['price'];
    }
        return view('orders.cart', compact('cart','totalPrice'));

    }
    public function checkout()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('orders.showProducts')->with('error', 'Your cart is empty');
        }

        $order = Order::create([
            'user_id' => Auth::id(),
            'order_date' => now(),
            'total_amount' => array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart)),
            'status' => 'pending'
        ]);

        foreach ($cart as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price']
            ]);
        }

        session()->forget('cart');

        return redirect()->route('orders.showProducts')->with('status', 'Order placed successfully');
    }
}
