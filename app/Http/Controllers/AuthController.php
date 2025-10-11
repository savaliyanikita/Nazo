<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function checkEmail(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if ($user) {
            return response()->json([
                'success' => true,
                'exists'  => true,
                'name'    => $user->name
            ]);
            
        }
        return response()->json([
            'success' => true,
            'exists'  => false
        ]);
    }

    public function login(Request $request)
    {
        try {
            if (Auth::attempt($request->only('email', 'password'), $request->remember)) {
                $request->session()->regenerate();

                return response()->json([
                    'success' => true,
                    'redirect' => url('/'), // redirect to home page
                ]);
            }

            if (!Auth::attempt($request->only('email', 'password'), $request->remember)) {
                return response()->json([
                    'success' => false,
                    'message' => "Sorry, that email address and/or password doesn't match our records."
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials',
            ], 401);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(), // shows exact error
            ], 500);
        }
    }


    public function signup(Request $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        Auth::login($user);

        return response()->json([
            'success' => true,
            'redirect' => url('/my-account') // ✅ custom account page
        ]);
    }
}
