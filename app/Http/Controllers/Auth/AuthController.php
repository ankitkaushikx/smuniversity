<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    //

    public function login(Request $request){
        $fields = $request->validate([
            'phone_number' => ['required', 'regex:/^\d{10}$/'],
            'password' => 'required|string',
        ]);

        //Attempt to login user
        if(Auth::attempt($fields, $request->remember)){
            return redirect()->intended('/dashboard');

        } else {
            return back()->withErrors([
                'failed' => 'The provided Phone Number & Password do not match any credentials',
            ]);
        }
    }
}
