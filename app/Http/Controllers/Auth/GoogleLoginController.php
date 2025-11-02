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

            $loggedInUser = null;

            if ($user) {

                // Pastikan google_id dan verifikasi email terisi
                if (is_null($user->google_id)) {
                    $user->google_id = $googleUser->getId();
                }
                if (is_null($user->email_verified_at)) {
                    $user->email_verified_at = now();
                }
                $user->save(); // Simpan perubahan

                $loggedInUser = $user;

            } else {
                // --- JIKA USER BELUM ADA (USER BARU) ---

                // Buat user baru
                $newUser = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'email_verified_at' => now(), // Anggap terverifikasi karena dari Google
                    'password' => null
                ]);


                $loggedInUser = $newUser;

            }
            // 1. Login-kan user-nya
            Auth::login($loggedInUser, true);

            // 2. Cek rolenya
            if ($loggedInUser->is_admin == 1) {
                // JIKA ADMIN, lempar ke dashboard admin
                return redirect()->route('filament.admin.pages.dashboard');
            } else {
                // JIKA BUKAN, lempar ke dashboard pelanggan
                return redirect()->intended('/');
            }


        } catch (\Exception $e) {
            // Jika ada error, kembali ke halaman login
            report($e); // Laporkan error
            return redirect('/login')->with('error', 'Login dengan Google gagal, silakan coba lagi.');
        }
    }
}
