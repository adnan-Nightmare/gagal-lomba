<?php

namespace App\Http\Controllers;

use App\Models\store;
use App\Models\products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{
    function homeShow(){
        $products = products::with('category')->limit(8)->get();

        return view('home', compact('products'));
    }

    function productShow($slug){
        $product = products::where('slug', $slug)->firstOrFail();

        return view('product', compact('product'));
    }

    public function profileShow($toko){
        $store = store::where('name', $toko)->firstOrFail();
        $product = products::where('toko', $store->name)->get();


        return view('profileStore', ['store' => $store,'product' => $product]);
    }

   
}
