<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

class LoginController extends Controller
{
    public function login() {
        return view('login');
    }

    public function home() {
        return view('homepage');
    }

    public function authenticate(Request $request) {
        $validation = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:5|max:12'
        ]);

        $remember = $request->has('remember') ? true : false;

        if(auth()->attempt($validation, $remember)) {
            $request->session()->regenerate();
            return redirect()->intended('/home');
        }

        return back()->with('loginError', 'Login failed !');
    }

    public function register() {
        return view('register');
    }

    public function store(Request $request) {
        $validation = $request->validate([
            'name' => 'required|min:3|max:20',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:5|max:12'
        ]);

        $validation['password'] = bcrypt($validation['password']);

        $user = User::create($validation);

        auth()->login($user);
        $request->session()->regenerate();

        return redirect()->intended('/home');
    }

    public function logout(Request $request) {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
