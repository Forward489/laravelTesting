<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

class LoginController extends Controller
{
    //Melakukan return view login
    public function login() {
        return view('login');
    }

    // Melakukan return view home jika berhasil login
    public function home() {
        return view('homepage');
    }

    // Melakukan validasi login
    public function authenticate(Request $request) {
        $validation = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:5|max:12'
        ]);

        // Cek apakah remember me dicentang, jika ya, maka akan menyimpan cookie
        $remember = $request->has('remember') ? true : false;

        // Jika berhasil login, maka akan redirect ke halaman home
        // remember me berisi true atau false
        if(auth()->attempt($validation, $remember)) {
            $request->session()->regenerate();
            return redirect()->intended('/home');
        }

        return back()->with('loginError', 'Login failed !');
    }

    // Melakukan return view register
    public function register() {
        return view('register');
    }

    // Melakukan validasi register dan menyimpan ke database
    public function store(Request $request) {
        $validation = $request->validate([
            'name' => 'required|min:3|max:20',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:5|max:12'
        ]);

        // Hash password
        $validation['password'] = bcrypt($validation['password']);

        // Create user dari instance $validation
        $user = User::create($validation);

        // Login user otomatis setelah register
        auth()->login($user);
        // Regenerate session token
        $request->session()->regenerate();

        // Redirect ke halaman home setelah register
        return redirect()->intended('/home');
    }

    public function logout(Request $request) {
        // Logout user
        auth()->logout();
        // Invalidate session
        $request->session()->invalidate();
        // Regenerate session token
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
