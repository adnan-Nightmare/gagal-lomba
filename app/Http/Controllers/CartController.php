<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function show(){
        $carts = Cart::with('product')->where('user_id', Auth::user()->id)->get();

        return view('carts', compact('carts'));
    }

    public function addToCart(Request $request){
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1|max:3',
        ]);

        $cartItem = Cart::where('user_id', Auth::user()->id)->where('product_id', $request->product_id)->first();

        if ($cartItem) {
            $cartItem->quantity += $request->quantity;
            $cartItem->save();
        }else{
            Cart::create([
                'user_id' => Auth::user()->id,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
            ]);
        }

        return redirect()->back()->with('success', 'Item Added Successfully');
    }

    public function buy(Request $request){
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1|max:3',
        ]);

        $cartItem = Cart::where('user_id', Auth::user()->id)->where('product_id', $request->product_id)->first();

        if ($cartItem) {
            $cartItem->quantity += $request->quantity;
            $cartItem->save();
        }else{
            Cart::create([
                'user_id' => Auth::user()->id,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
            ]);
        }

        return redirect()->route('showCart')->with('success', 'Item Added Successfully');

    }

    public function destroy($id){
        $cart = Cart::find($id);

    if ($cart) {
        $cart->delete();
        return response()->json(['success' => true]);
    }

    return response()->json(['success' => false], 404);
        // return redirect()->back()->with('success', 'Item Removed Successfully');
    }
}
