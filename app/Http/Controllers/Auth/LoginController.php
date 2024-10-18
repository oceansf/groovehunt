<?php

namespace App\Http\Controllers\Auth;
use App\Models\User;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('google')->stateless()->redirect();
    }
    /**
     * Obtain the user information from Google.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();
        
        // Create a new user in database
        $googleUser = User::firstOrCreate(
            [
                'provider_id' => $googleUser->getId(),
            ],
            [
                'email' => $googleUser->getEmail(),
                'name' => $googleUser->getName(),
                'avatar' => $googleUser->getAvatar(),
            ]
        );
        // $user = User::where('provider_id', $googleUser->getId())->first();
        // // Create a new user in our database
        // if (! $user) {
        //     $user = User::create([
        //         'email' => $googleUser->getEmail(),
        //         'name' => $googleUser->getName(),
        //         'provider_id' => $googleUser->getId(),
        //     ]);
        // }

        // Log the user in
        auth()->login($googleUser, true);

        // Redirect to dashboard
        return redirect('/');
    }
}