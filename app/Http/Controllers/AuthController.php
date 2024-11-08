<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\SendOtpMail;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Mail\sendResetEmailMail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;

class AuthController extends Controller
{
    function showLogin(){
        return view('welcome', ['title' => 'login']);
    }

    
    protected function remember($remember){

    }

    function login(Request $request){
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ],[
            'email.required' => 'email tidak ditemukan',
            'password.required' => 'password tidak ditemukan'
        ]);

        $acc = [
            'email' => $request->email,
            'password' => $request->password
        ];

        $remember = $request->has('remember');

        
        if(Auth::attempt($acc, $remember)){
            // cek verifikasi email
            if(Auth::user()->email_verified_at == null){
                $user = User::where('email', $request->email)->firstOrFail();

                $otp = rand(100000, 999999);

                $user->otp = Hash::make($otp);
                $user->otp_expires_at = now();
                $user->save();

                $url = URL::temporarySignedRoute('verify', now()->addMinutes(30));

                Mail::to($user->email)->send( new SendOtpMail($otp));

                return redirect()->route('verify')->with('login success go to verify');
            }else{
                $request->session()->regenerate();
                return redirect()->route('home')->with('login success');
            }
        }else{
            return redirect('')->withErrors('Akun tidak ada')->withInput();
        }
    }


    function logout(Request $request){
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('logout success');
    }

    // reset password


    // email
    function showResetEmail(){
        $user = Auth::user();

        $signedUrl = URL::temporarySignedRoute(
            'confirmEmail',
            Carbon::now()->addMinutes(10),
            ['user' => $user->id]
        );

        Mail::to($user->email)->send(new SendResetEmailMail($user->username, $signedUrl));

        return redirect()->route('profile')->with('Email konfirmasi telah dikirim.');
    }

    function confimEmail(Request $request, $user){
        $user = User::findOrFail($user);

        if($user->email !== Auth::user()->email){
            abort(403);
        }

        return view('resetEmail');
    }

    function updateEmail(Request $request){
        $request->validate([
            'new_email' =>'required|email|unique:users,email',
        ],[
            'new_email.required' => 'Email baru harus diisi.',
            'new_email.email' => 'Email harus valid.',
            'new_email.unique' => 'Email baru sudah terdaftar.',
        ]);
    
        $userAcc = Auth::user();
        $user = User::where('username', $userAcc->username)->firstOrFail();
        $user->email = $request->new_email;
        $user->save();
    
        return redirect()->route('profile')->with('success', 'Email berhasil diperbarui.');
    }

    // verify
    function showVerify(){
        return view('auth.verify');
    }

    function verifyOTP(Request $request){
        $request->validate([
            'otp' => 'required|array',
            'otp.*' => 'required|numeric|digits:1',
        ],[
            'otp' => 'Masukan kode otp dengan benar!!!',
            'otp.*.required' => 'Kode OTP harus diisi.',
            'otp.*.numeric' => 'Kode OTP hanya boleh berupa angka.',
        ]);

        $otp = implode('', $request->otp);
        $user = Auth::user();

        $otpRecord = User::where('email', $user->email)->first();

        if($otpRecord && !User::isExpired($otpRecord) && Hash::check($otp, $otpRecord->otp)){
            $otpRecord->email_verified_at = now();
            $otpRecord->otp = null;
            $otpRecord->otp_expires_at = null;
            $otpRecord->save();
            $request->session()->regenerate();
            return redirect()->route('home')->with('verify success');
        }else{
            return redirect()->route('verify')->withErrors('Kode OTP salah!!!');
        }
    }

    function verifySendOTP(Request $request){
        $user = Auth::user();
        $acc = User::where('email', $user->email)->first();

        // clear otp
        $acc->otp = null;
        $acc->otp_expires_at = null;
        $acc->save();

        $otp = rand(100000, 999999);

        $acc->otp = Hash::make($otp);
        $acc->otp_expires_at = now();
        $acc->save();

        Mail::to($user->email)->send( new SendOtpMail($otp));

        return redirect()->route('verify')->with('OTP sudah terkirim');
    }
}
