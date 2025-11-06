<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
     public function edit(Request $request): View
    {
        // Ambil data order milik user, urutkan dari terbaru
        // PENTING: Eager load relasi 'items' dan 'items.product'
        $orders = $request->user()->orders()
                                ->with('items.product') // Ambil juga item & info produknya
                                ->latest()
                                ->paginate(5); // Batasi 5 per halaman

        return view('profile.edit', [
            'user' => $request->user(),
            // 'orders' => $orders, // Kirim data order ke view
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('home')->with('status', 'profile telah berhasil diperbarui');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::route('home')->with('status', 'Akun Anda telah berhasil dihapus.');
    }
}
