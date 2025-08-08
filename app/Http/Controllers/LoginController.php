<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login', [
            'title' => 'Page Login'
        ]);
    }

    public function dologin(Request $request)
    {
        // Validasi input dasar
        $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Kunci throttling: menggunakan IP address
        // Ini akan membatasi semua percobaan login dari satu IP
        $throttleKey = $request->ip();

        // BATASAN LOGIN
        // Cek apakah user sudah melebihi batas percobaan login (5 kali dalam 1 menit)
        if (RateLimiter::tooManyAttempts($throttleKey, 5, 60)) {
            $seconds = RateLimiter::availableIn($throttleKey);

            // Simpan flash message dan countdown di session
            $request->session()->flash('countdown_seconds', $seconds);
            $request->session()->flash('error', 'Terlalu banyak percobaan login. Silakan coba dalam 1 menit lagi.');

            // Arahkan kembali dengan error
            return back();
        }

        // Cek email dan password
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $request->session()->regenerate();

            // Jika login berhasil, reset percobaan throttling
            RateLimiter::clear($throttleKey);

            if (auth()->user()->role_id === 1) {
                return redirect()->intended('/dashboard/admin');
            } else if (auth()->user()->role_id === 2) {
                return redirect()->intended('/dashboard/bendahara');
            } else {
                return redirect()->intended('/dashboard/karyawan');
            }
        } else {
            // Tambahkan percobaan gagal login
            RateLimiter::hit($throttleKey, 60); // Waktu tunggu per percobaan gagal adalah 60 detik

            // Hitung sisa percobaan
            $remainingAttempts = 5 - RateLimiter::attempts($throttleKey);
            
            if ($remainingAttempts <= 0) {
                $seconds = RateLimiter::availableIn($throttleKey);
                $request->session()->flash('countdown_seconds', $seconds);
                $message = "Terlalu banyak percobaan login. Silakan coba dalam 1 menit lagi.";
            } elseif ($remainingAttempts <= 2) {
                $message = "Email atau Password salah. Anda memiliki {$remainingAttempts} percobaan lagi.";
            } else {
                $message = "Email atau Password salah.";
            }

            return back()->with('error', $message);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}