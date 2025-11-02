<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        // Logika validasi yang dinamis
        $rules = [
            'password' => ['required', 'confirmed', Password::defaults()],
        ];

        // Jika user SUDAH punya password, tambahkan validasi 'current_password'
        if ($user->password !== null) {
            $rules['current_password'] = ['required', 'current_password'];
        }

        // Validasi input
        $validated = $request->validateWithBag('updatePassword', $rules);

        // Update password user
        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('status', 'password-updated');
    }
}
