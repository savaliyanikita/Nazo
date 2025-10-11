<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'account_type' => 'required|in:personal,business',
        ]);

        if (app()->environment('production')) {
            $request->validate([
                'g-recaptcha-response' => 'required|captcha',
            ]);
        
            // Verify captcha
            $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret'   => env('RECAPTCHA_SECRET_KEY'),
                'response' => $request->input('g-recaptcha-response'),
                'remoteip' => $request->ip(),
            ]);

            if (! $response->json()['success']) {
                return back()->withErrors(['captcha' => 'Captcha verification failed. Please try again.']);
            }
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'account_type' => $request->account_type,
        ]);

        // event(new Registered($user)); // 👈 sends email verification
        Auth::login($user);
        // auth()->login($user); // auto-login after signup

        // return redirect(route('dashboard', absolute: false));
        // return redirect()->route('verification.notice');
        // Redirect to account dashboard
        // return redirect()->route('account.dashboard');
        return redirect()->intended(route('home'));
    }
}
