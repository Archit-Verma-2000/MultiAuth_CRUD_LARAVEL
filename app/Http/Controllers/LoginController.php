<?php

namespace App\Http\Controllers;

use App\Models\MultiAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Models;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    //this method will show login page for customer
    public function index()
    {
        return view('login');
    }
    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);
        if ($validator->passes()) {
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                return redirect()->route('account.dashboard');
            } else {
                return redirect()->route('account.login')->with('fail', 'Either email or password is incorrect');
            }
        } else {
            return redirect()->route('account.login')->withInput()->withErrors($validator);
        }
    }
    //this method is for register page
    public function register(Request $request)
    {

        return view('register');
    }
    public function processRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:250',
            'email' => 'required|email|unique:tb_multi_auth',
            'password' => 'required|min:6|confirmed',
        ]);
        if ($validator->passes()) {
            $user = new MultiAuth();
            $user->name = $request->name;
            $user->password = Hash::make($request->password);
            $user->email = $request->email;
            $user->role = 'customer';
            $user->save();
            return redirect()->route('account.login')->with('success', 'You have registered successfully');
        } else {
            return redirect()->route('account.register')->withInput()->withErrors($validator);
        }
    }
    public function logout()
    {
        Auth::logout();
        return redirect()->route('account.login');
    }
}
