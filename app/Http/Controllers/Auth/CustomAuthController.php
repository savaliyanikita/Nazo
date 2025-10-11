<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class CustomAuthController extends Controller
{
    /**
     * Check if email exists
     */
    public function checkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        if ($user) {
            Auth::login($user);

            return response()->json([
                'success' => true,
                'message' => 'Logged in successfully',
                'redirect' => route('account'), // optional
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'No account found with this email',
        ], 200);
    }

    /**
     * Handle login
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($request->only('email', 'password'), $request->remember)) {
            return response()->json([
                'success' => true,
                'redirect' => route('account'),
                'message' => 'Login successful'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid credentials'
        ], 401);
    }

    /**
     * Handle register
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        Auth::login($user);

        return response()->json([
            'success' => true,
            'redirect' => route('account'),
            'message' => 'Account created successfully'
        ]);
    }

    /**
     * Handle logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();

        return response()->json([
            'success' => true,
            'redirect' => url('/')
        ]);
    }
}
