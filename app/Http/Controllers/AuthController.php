<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    // tampil halaman login
    public function login()
    {
        return view('login');
    }

    // proses login
    public function actionLogin(Request $request)
    {
        $request->validate([
            'nis' => 'required',
            'password' => 'required'
        ]);

        $user = User::where('nis', $request->nis)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Session::put('login', true);
            Session::put('user', $user->name);
            Session::put('user_id', $user->id);
            Session::put('role', $user->is_admin ? 'admin' : 'user');

            return redirect('/dashboard');
        }

        return back()->with('error', 'NIS atau password salah');
    }

    // tampil halaman register
    public function register()
    {
        return view('register');
    }

    // proses register
    public function actionRegister(Request $request)
    {
        $request->validate([
            'nis' => 'required|unique:users,nis',
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:4'
        ]);

        User::create([
            'nis' => $request->nis,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_admin' => false // User biasa tidak bisa jadi admin
        ]);

        return redirect('/login')->with('success', 'Berhasil daftar');
    }

    // logout
    public function logout()
    {
        Session::flush();
        return redirect('/login');
    }
}