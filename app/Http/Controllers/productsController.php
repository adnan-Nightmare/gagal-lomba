<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\store;
use App\Models\category;
use App\Models\products;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class productsController extends Controller
{
    function myStore(){
        $store = store::where('user_id', Auth::user()->id)->with('products')->first();

        $products = $store->products;
        if(!$products){
            return view('mystore', ['store' => $store, 'products' => $products]);    
        }else{
            return view('mystore', ['store' => $store, 'products' => $products]);    
        }

    }

    function showAddProduct(){
        $categories = category::all();

        return view('addProduct', compact('categories'));
    }

    function addProduct(Request $request){
        $request->validate([
            'judul' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:1',
            // 'category' => 'required'
            'thumbnail' => 'required|mimes:png,jpg,jpeg|max:2048'
        ]);

        $store = store::where('user_id', Auth::user()->id)->with('products')->first();

        do{
            $slug = Str::random(30);
        }while(products::where('slug', $slug)->exists());

        $data = [
            'judul' => $request->judul,
            'description' => $request->description,
            'toko' => $store->name,
            'price' => $request->price,
            'stock_quantity' => $request->stock,
            'slug' => $slug,
            'category_id' => $request->categories
        ];

        if($request->hasFile('thumbnail')){
            $image = $request->file('thumbnail');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/products'), $imageName);
            $data['thumbnail'] = $imageName;
        }

        $product = products::create($data);

        $store->products()->attach($product->id);
        $product->category()->attach($request->input('categories'));
        $product->save();

        return redirect()->route('myStore')->with('success', 'Product has been added');
    }
}
