<?php

namespace App\Http\Controllers;

use App\Models\store;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class userController extends Controller
{
    function myProfile(){
        $user = Auth::user();
        $namaToko = store::where('user_id', $user->id)->first();

        return view('myProfile', ['profile' => $user->profile, 'username' => $user->username, 'toko' => $namaToko]);
    }

    function updateProfile(Request $request){
        $request->validate([
            'username' => 'required',
            'profile' => 'nullable|mimes:png,jpg,jpeg|max:2048',
            'toko' => 'required'
        ]);
        $user = User::Where('email', Auth::user()->email)->firstOrFail();
        $toko = store::Where('user_id', $user->id)->first();

        if($toko){
            $toko->name = $request->toko;
            $toko->save();
        }else{
            store::create([
                'user_id' =>$user->id,
                'name' =>$request->toko,
            ]);
        }

        if($request->hasFile('profile')){
            if($user->profile){
                $oldImage = public_path('profileUsers/' . $user->profile);
                if(file_exists($oldImage)){
                    unlink($oldImage);
                }
            }

            $image = $request->file('profile');
            $imageName = time(). '.'. $image->getClientOriginalExtension();
            $image->move(public_path('profileUsers/'), $imageName);
            $user->profile = $imageName;
        }

        $user->username = $request->username;
        $user->save();

        return redirect()->route('home')->with('success', 'Profile berhasil diupdate');
    }

}
