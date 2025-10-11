<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Support\CartResolver;        // if you want to merge cart after login
use App\Support\WishlistResolver;    // if you have one; optional
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    /** Kick user to provider */
    public function redirect(string $provider)
    {
        abort_unless(in_array($provider, ['google','facebook','apple']), 404);

        return Socialite::driver($provider)->stateless()->redirect();
    }

    /** Handle provider callback */
    public function callback(string $provider)
    {
        abort_unless(in_array($provider, ['google','facebook','apple']), 404);

        $socialUser = Socialite::driver($provider)->stateless()->user();

        // Some providers (FB/Apple depending on scope) may not return email
        $email = $socialUser->getEmail();
        if (!$email) {
            $email = sprintf('%s@%s.local', Str::uuid(), $provider);
        }

        $user = User::where('provider', $provider)
                    ->where('provider_id', $socialUser->getId())
                    ->first();

        if (!$user) {
            $user = User::firstOrCreate(
                ['email' => $email],
                [
                    'name'        => $socialUser->getName() ?: ($socialUser->user['name']['firstName'] ?? 'User'),
                    'password'    => bcrypt(Str::random(32)), // not used
                ]
            );

            $user->provider    = $provider;
            $user->provider_id = $socialUser->getId();
            $user->save();
        }

        Auth::login($user, true);

        // Optional: merge guest cart/wishlist into account
        if (class_exists(CartResolver::class)) {
            CartResolver::attachGuestToUser($user->id);
        }
        if (class_exists(WishlistResolver::class)) {
            WishlistResolver::attachGuestToUser($user->id);
        }

        return redirect()->intended(route('home'));
    }
}
