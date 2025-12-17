<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Menampilkan form login.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Memproses permintaan login.
     */
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // --- Perubahan untuk pesan error spesifik ---
        // Peringatan Keamanan: Memberitahu secara spesifik apakah email atau password
        // yang salah dapat menjadi risiko keamanan, karena memungkinkan penyerang
        // untuk menebak email yang terdaftar.

        $user = User::where('email', $request->email)->first();

        // 1. Cek apakah user dengan email tersebut ada
        if (! $user) {
            return back()->with('error', 'Email tidak terdaftar.');
        }

        // 2. Jika user ada, coba otentikasi
        if (Auth::attempt($request->only('email', 'password'))) {
            // Jika berhasil, buat ulang sesi
            $request->session()->regenerate();

            // Alihkan ke halaman yang dituju
            return redirect()->intended('/user/beranda');
        }

        // 3. Jika otentikasi gagal, berarti password salah
        return back()->with('error', 'Kata Sandi salah.');
    }

    /**
     * Menampilkan form registrasi.
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Memproses permintaan registrasi.
     */
    public function register(Request $request)
    {
        // Aturan validasi
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'no_wa' => 'required|string|max:20',
        ]);

        // Jika validasi gagal, kembali dengan error
        if ($validator->fails()) {
            return redirect('register')
                ->withErrors($validator)
                ->withInput();
        }

        // Buat user baru
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
            'no_wa' => $request->no_wa,
            'role' => 'user',
        ]);

        // Alihkan ke halaman login dengan pesan sukses
        return redirect('/login')->with('success', 'Registrasi berhasil! Silakan masuk.');
    }

    /**
     * Memproses permintaan logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Alihkan ke beranda user setelah logout
        return redirect('/user/beranda');
    }
}
