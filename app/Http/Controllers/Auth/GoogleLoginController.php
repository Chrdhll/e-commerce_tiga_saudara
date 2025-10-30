<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleLoginController extends Controller
{
    /**
     * Mengarahkan pengguna ke halaman login Google.
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Menerima callback dari Google setelah login.
     */
    public function handleGoogleCallback()
    {
        try {
            // 1. Ambil data user dari Google
            $googleUser = Socialite::driver('google')->user();

            // 2. Cari user di database kita
            // Kita cari berdasarkan google_id, ATAU berdasarkan email
            $user = User::where('google_id', $googleUser->getId())
                        ->orWhere('email', $googleUser->getEmail())
                        ->first();

            if ($user) {
                // --- JIKA USER SUDAH ADA ---

                // Jika user ada tapi google_id-nya kosong (mungkin dulu daftar manual)
                // kita update google_id-nya.
                $user->update([
                    'google_id' => $googleUser->getId(),
                    'email_verified_at' => now(),
                ]);

                // Login-kan user
                Auth::login($user, true); 
                return redirect()->intended('/dashboard');

            } else {
                // --- JIKA USER BELUM ADA (USER BARU) ---

                // Buat user baru
                $newUser = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'email_verified_at' => now(), // Anggap terverifikasi karena dari Google
                    'password' => Hash::make(Str::random(24)) // Buat password acak (karena wajib ada)
                ]);

                // Login-kan user baru
                Auth::login($newUser, true);
                return redirect()->intended('/dashboard');
            }

        } catch (\Exception $e) {
            // Jika ada error, kembali ke halaman login
            report($e); // Laporkan error
            return redirect('/login')->with('error', 'Login dengan Google gagal, silakan coba lagi.');
        }
    }
}
