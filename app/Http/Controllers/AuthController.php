<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function login()
    {
        if(Auth::check())
        {
            return redirect()->route('user');
        }
        return view('pages.login');
    }

    public function postLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|min:5|email|exists:users',
            'password' => 'required|min:5',
        ]);

        $email = $request->email;
        $password = $request->password;
        if(Auth::attempt(['email' => $email, 'password' => $password]))
        {
            return redirect()->route('user');
        }
        else
        {
            return redirect()->route('login')->with('error', 'Enter Valid Email Or password');
        }
    }

    public function register()
    {
        if(Auth::check())
        {
            return redirect()->route('user');
        }
        return view('pages.register');
    }

    public function postRegister(Request $request)
    {
        
        
        $request->validate([
            'name' => 'required|min:2',
            'email' => 'required|min:5|email|unique:users',
            'password' => 'required|min:5',
            'cpassword' => 'required|min:5|same:password',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();
        if($user->save())
        {
            return redirect()->route('login')->with('success', 'User Registered Sucessfully');
        }
    }

    public function user()
    {
        if(Auth::check())
        {
            return view('user.index');
        }
        else
        {
            return redirect()->route('login');
        }
    }


    public function logout()
    {
        Session::flush();
        Auth::logout();
        return redirect()->route('login')->with('success', 'User Logout Sucessfully');
    }
}
