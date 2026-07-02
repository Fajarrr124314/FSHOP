<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     */
    public function redirectToGoogle()
    {
        // If Google credentials are not set in .env, redirect to mock selector modal/route
        if (empty(env('GOOGLE_CLIENT_ID')) || empty(env('GOOGLE_CLIENT_SECRET'))) {
            return redirect()->route('auth.mock-view');
        }

        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Google.
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            // Check if user exists or create them
            $user = User::updateOrCreate([
                'email' => $googleUser->getEmail(),
            ], [
                'name' => $googleUser->getName(),
                'google_id' => $googleUser->getId(),
                'avatar' => $googleUser->getAvatar(),
                // Password is nullable, but we can set a random token if needed
            ]);

            // Assign role dynamically based on email
            if ($user->email === 'admin@fshop.space' || $user->email === env('ADMIN_EMAIL')) {
                $user->update(['role' => 'admin']);
            }

            Auth::login($user, true);

            return redirect('/')->with('success', 'Berhasil login menggunakan akun Google!');
        } catch (\Exception $e) {
            \Log::error('Google OAuth callback error', ['msg' => $e->getMessage()]);
            return redirect('/')->with('error', 'Gagal login menggunakan Google. Silakan coba lagi.');
        }
    }

    /**
     * Display mock login selector.
     */
    public function showMockLogin()
    {
        return view('auth.mock_login');
    }

    /**
     * Simulate Google login locally.
     */
    public function handleMockLogin($profile)
    {
        if ($profile === 'admin') {
            $user = User::where('email', 'admin@fshop.space')->first();
            if (!$user) {
                $user = User::create([
                    'name' => 'FSHOP Admin (Mock)',
                    'email' => 'admin@fshop.space',
                    'role' => 'admin',
                    'google_id' => '100000000000000000001',
                    'avatar' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
                ]);
            }
        } else {
            $user = User::where('email', 'customer@fshop.space')->first();
            if (!$user) {
                $user = User::create([
                    'name' => 'FSHOP Customer (Mock)',
                    'email' => 'customer@fshop.space',
                    'role' => 'customer',
                    'google_id' => '100000000000000000002',
                    'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
                ]);
            }
        }

        Auth::login($user, true);

        return redirect('/')->with('success', 'Berhasil login (Simulated Google Auth)!');
    }

    /**
     * Log user out of application.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('success', 'Berhasil logout.');
    }
}
