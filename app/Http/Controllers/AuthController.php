<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

use App\Http\Requests\LoginRequest;

class AuthController extends Controller
{
    public function login()
    {
        return view('layouts.auth.login');
    }

    public function loginproses(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']], $request->boolean('remember'))) {
            $request->session()->regenerate();
            Alert::success('Berhasil', 'Selamat datang kembali, ' . Auth::user()->name);
            return redirect()->intended('/dashboard');
        }

        Alert::error('Gagal', 'email atau password salah. Silakan coba lagi.');
        return back()->withInput(['email' => $request->email]);
    }


    public function logout()
    {
        Auth::logout();
        Alert::success('Berhasil', 'Logout berhasil')
            ->autoclose(4000)
            ->toToast()
            ->timerProgressBar()
            ->iconHtml('<i class="fa-solid fa-check"></i>');
        return redirect()->route('login');
    }
}
