<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Contracts\User as SocialiteUser;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;

class SocialAuthController extends Controller
{

     /**
     * Google Login
     */

     public function redirectToAuth(): JsonResponse
    {
        return response()->json([
            'url' => Socialite::driver('google')
                         ->stateless()
                         ->redirect()
                         ->getTargetUrl(),
        ]);
    }

    public function handleAuthCallback(): JsonResponse
    {
        try {
            /** @var SocialiteUser $socialiteUser */
            $socialiteUser = Socialite::driver('google')->stateless()->user();
        } catch (ClientException $e) {
            return response()->json(['error' => 'Invalid credentials provided.'], 422);
        }

        /** @var User $user */
        $user = User::query()
            ->firstOrCreate(
                [
                    'email' => $socialiteUser->getEmail(),
                ],
                [
                    'email_verified_at' => now(),
                    'name' => $socialiteUser->getName(),
                    'password' =>Hash::make($socialiteUser->getId()),
                    'google_id' => $socialiteUser->getId(),
                    'avatar' => $socialiteUser->getAvatar(),
                ]
            );

       // event(new Registered($user));

       // Auth::login($user);



         return response()->json([
             'user' => $user,
             'access_token' => $user->createToken('google-token')->plainTextToken,
             'token_type' => 'Bearer',
         ]);

       // return response()->noContent();

    }
}
