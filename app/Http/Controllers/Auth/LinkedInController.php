<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class LinkedInController extends Controller
{
    public function redirectToLinkedIn()
    {
        return Socialite::driver('linkedin-openid')->redirect();
    }

    public function handleLinkedInCallback()
    {
        try {
            $googleUser = Socialite::driver('linkedin-openid')->user();

            // Find or create the user in your database
            $user = User::firstOrCreate([
                'email' => $googleUser->getEmail(),
            ], [
                'name' => $googleUser->getName(),
                //'google_id' => $googleUser->getId(), // Store the Google ID
                'email' => $googleUser->getEmail(),
                'password' => encrypt('123456dummy')
            ]);

            // Log the user into the Laravel application
            Auth::login($user);
            return redirect()->intended('dashboard');

        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
}
