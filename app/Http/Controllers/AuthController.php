<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Menampilkan halaman form login
    public function showLogin()
    {
        return view('auth.login');
    }

    // Memproses data login mencocokkan ke database
    public function processLogin(Request $request)
    {
        $request->validate([
            'username' => 'required', // Tetap bisa terima inputan username/email dari form
            'password' => 'required',
        ]);

        // Cek apakah input berupa email atau nama (username)
        $fieldType = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'email'; 
        // Karena di database kolomnya email (admin@rental.com), kita arahkan login pakai email atau sesuaikan

        // Percobaan login menggunakan Auth::attempt Laravel
        // (Catatan: Jika form kamu menggunakan email, pastikan input form diisi email seperti admin@rental.com atau staff@rental.com)
        if (Auth::attempt(['email' => $request->username, 'password' => $request->password])) {
            $request->session()->regenerate();
            return redirect()->intended('/')->with('success', 'Berhasil login ke sistem!');
        }

        return back()->withErrors([
            'username' => 'Username atau Password salah!',
        ])->withInput();
    }

    // Proses logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Berhasil logout dari sistem.');
    }
}