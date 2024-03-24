<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    public function home()
    {

        if (Auth::id()) {
            if (!auth()->user()->roles->isempty()) {
                $user_role = auth()->user()->roles->first()->name;
                if ($user_role == '') {
                    return view('');
                }
            }
            return view('user.home');
        }
    }
    public function checkLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('');
        }
        return redirect()->back()->withErrors(['Error' => 'Invalid Email or Password']);
    }
    public function logout()
    {
        Auth::logout();
        return redirect()->back();
    }
}
