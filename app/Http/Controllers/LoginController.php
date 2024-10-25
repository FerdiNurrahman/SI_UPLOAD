<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Menampilkan halaman login 
    public function index()
    {
        return view('login/login');
    }

    // Authenticate user
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Set success message and redirect to dashboard
            $userName = Auth::user()->name; // Assuming the name field is stored in the `accounts` table

            // Set success message with the user's name
            return redirect()->intended('dashboard')->with('success', "Selamat Datang $userName!");
        }

        // Set error message and return to login
        return back()->with('error', 'Username atau password salah.');
    }

    // Logout user
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Anda telah berhasil logout.');
    }
}
