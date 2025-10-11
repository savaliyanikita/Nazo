<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Support\CartResolver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthPopupController extends Controller
{
    public function login(Request $r)
    {
        $data = $r->validate([
            'email'    => ['required','email'],
            'password' => ['required'],
            'remember' => ['nullable','boolean'],
        ]);

        if (!Auth::attempt(['email'=>$data['email'],'password'=>$data['password']], $r->boolean('remember'))) {
            throw ValidationException::withMessages(['email' => 'Invalid credentials.']);
        }

        $r->session()->regenerate();

        // merge guest cart
        CartResolver::attachGuestToUser(Auth::id());

        return response()->json(['ok' => true]);
    }

    public function register(Request $r)
    {
        $data = $r->validate([
            'email'        => ['required','email','unique:users,email'],
            'name'         => ['required','string','max:255'],
            'password'     => ['required','min:6'],
            'account_type' => ['required','in:personal,business'],
        ]);

        $user = User::create([
            'name'         => $data['name'],
            'email'        => $data['email'],
            'password'     => Hash::make($data['password']),
            'account_type' => $data['account_type'],
        ]);

        Auth::login($user);
        CartResolver::attachGuestToUser($user->id);

        return response()->json(['ok' => true]);
    }
}
