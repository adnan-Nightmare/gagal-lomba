<?php

namespace App\Http\Controllers;

use Midtrans\Snap;
use App\Models\Cart;
use App\Models\User;
use Midtrans\Config;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Models\ShippingMethod;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class OrderController extends Controller
{
    use AuthorizesRequests;

    public function __construct() {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.sanitized');
        Config::$is3ds = config('midtrans.3ds');
    }

    public function checkout(Request $request){
        $request->validate([
            'selected_items' => 'required|array',
            'selected_items.*' => 'exists:carts,id'
        ]);

        $selectedCarts = Cart::with('product')->whereIn('id', $request->selected_items)->get();

        $shippingMethods = ShippingMethod::all();

        return view('checkout', compact('selectedCarts','shippingMethods'));
    }

    public function placeOrder(Request $request){
        $request->validate([
            'shipping_method_id' => 'required|exists:shipping_methods,id',
            'address' => 'required|string',
            'items' => 'required|array',
            'items.*' => 'exists:carts,id'
        ]); 

        $userAddress = User::where('id', Auth::user()->id)->first();
        $carts = Cart::with('product')->whereIn('id', $request->items)->where('user_id', Auth::user()->id)->get();
        $total = $carts->sum(fn($cart) => $cart->product->price * $cart->quantity);


        $shippingMethodId = $request->shipping_method_id;
        $shippingMethod = ShippingMethod::where('id', $shippingMethodId)->first();
        $shippingCost = $shippingMethod->cost;
        $orderTotal = $total + $shippingCost + 5;
        
        $data = [
            'user_id' => Auth::user()->id,
            'total_amount' => $orderTotal,
            'shipping_method' => $shippingMethod->name,
            'payment_method' => 'Midtrans', 
            'status' => 'pending',
        ];

        $userAddress->alamat = json_encode([
            'alamat' => $request->address
        ]);
        $userAddress->save();
        
        $order = Order::create($data);
        
        foreach($carts as $cart){
            $dataItems = [
                'order_id' => $order->id,
                'product_id' => $cart->product_id,
                'quantity' => $cart->quantity,
                'price' => $cart->product->price,
            ];

            OrderItem::create($dataItems);

        //     // $cart->product->decrement('stock', $cart->stock_quantity);
        }

        $payload = [
            'transaction_details' => [
                'order_id' => $order->id,
                'gross_amount' => intval(round($orderTotal)),
            ],
            'customer_details' => [
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email,
            ],
        ];

        $snapToken = Snap::getSnapToken($payload);

        Cart::whereIn('id', $request->items)->delete();
        return view('payment', compact('order', 'snapToken'));
    }

    public function statusControll(){
        $orderItems = Order::where('status', '!=', 'delivered')->get();

        foreach($orderItems as $order){
            $timer = now()->diffInMinutes($order->status_updated_at ?? now());

            if($timer >= 2.5){
                $nextStatus = $this->getNextStatus($order->status);
                $order->update([
                    'status' => $nextStatus,
                    'last_status_update' => now()
                ]);
            }
        }

        return response()->json(['success' => true]);
    }

    private function getNextStatus($currentStatus)
    {
        $statuses = ['pending', 'processing', 'shipped', 'delivered'];
        $currentIndex = array_search($currentStatus, $statuses);

        return $statuses[min($currentIndex + 1, count($statuses) - 1)];
    }

    public function showPurchase(){
        $userId = Auth::user()->id;
        $orders = Order::with('items.product')->where('user_id', $userId)->orderBy('created_at', 'desc')->get();
        // dd($orders);

        foreach($orders as $order){
            $order->updateStatus();
            // dd($order->items);
        }

        return view('statusPesanan', compact('orders'));
    }

    public function paymentSuccess()
    {
        return view('success');
    }

}
