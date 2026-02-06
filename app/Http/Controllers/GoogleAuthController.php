<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    public function redirect()
    {
        $redirectUrl = config('services.google.redirect');
        Log::info('Google OAuth redirect initiated', ['redirect_uri' => $redirectUrl]);

        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try {
            $redirectUrl = config('services.google.redirect');
            Log::info('Google OAuth callback received', ['redirect_uri' => $redirectUrl]);

            $googleUser = Socialite::driver('google')->user();

            $user = User::where('google_id', $googleUser->getId())->first();

            if ($user) {
                // Update existing user's info
                $user->update([
                    'name' => $googleUser->getName(),
                    'avatar' => $googleUser->getAvatar(),
                ]);
            } else {
                // Check if email exists (user registered differently)
                $existingUser = User::where('email', $googleUser->getEmail())->first();

                if ($existingUser) {
                    // Link Google account to existing user
                    $existingUser->update([
                        'google_id' => $googleUser->getId(),
                        'avatar' => $googleUser->getAvatar(),
                    ]);
                    $user = $existingUser;
                } else {
                    // Create new user
                    $user = User::create([
                        'name' => $googleUser->getName(),
                        'email' => $googleUser->getEmail(),
                        'google_id' => $googleUser->getId(),
                        'avatar' => $googleUser->getAvatar(),
                        // users.password is non-nullable; generate a strong random password.
                        'password' => Hash::make(Str::random(32)),
                    ]);
                }
            }

            Auth::login($user);

            if ($user->is_admin) {
                return redirect()->route('admin.dashboard')
                    ->with('success', 'Welcome back, ' . $user->name . '!');
            }

            $intended = session('url.intended');
            $intendedPath = is_string($intended) ? parse_url($intended, PHP_URL_PATH) : null;
            if (is_string($intendedPath) && str_starts_with($intendedPath, '/admin')) {
                session()->forget('url.intended');
            }

            // Redirect based on intended URL (if any), otherwise to shop.
            return redirect()->intended(route('shop.index'))
                ->with('success', 'Welcome back, ' . $user->name . '!');
        } catch (\Exception $e) {
            return redirect()->route('shop.index')->with('error', 'Unable to login with Google. Please try again.');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('shop.index')->with('success', 'You have been logged out.');
    }
}
