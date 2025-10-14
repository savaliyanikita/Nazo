<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\SocialAuthController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\Auth\CustomAuthController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\AccountController;



// Step 1: check email
Route::post('/login-check', function (Request $request) {
    $request->validate(['email' => 'required|email']);
    $user = \App\Models\User::where('email',$request->email)->first();
    \App\Support\CartResolver::attachGuestToUser($user->id);

    return $user
        ? response()->json(['success'=>true,'exists'=>true,'name'=>$user->name])
        : response()->json(['success'=>false,'exists'=>false]);
})->name('login.check');

// Step 2: check password + login
Route::post('/login', function (Request $request) {
    $credentials = $request->only('email','password');

    if (Auth::attempt($credentials, true)) {
        return response()->json(['success'=>true,'redirect'=>route('home')]);
    }

    return response()->json(['success'=>false,'message'=>'Invalid credentials']);
})->name('auth.login');


/**
 * REGISTER (Sign up new user)
 */
Route::post('/register', function (Request $request) {
    $request->validate([
        'name'     => 'required|string|max:255',
        'email'    => 'required|email|unique:users,email',
        'password' => 'required|min:6|confirmed',
    ]);

    $user = User::create([
        'name'     => $request->name,
        'email'    => $request->email,
        'password' => Hash::make($request->password),
    ]);

    Auth::login($user);

    return response()->json([
        'success'  => true,
        'redirect' => route('account'),
    ]);
})->name('register');


/**
 * LOGOUT
 */
Route::post('/logout', function () {
    Auth::logout();

    return response()->json([
        'success'  => true,
        'redirect' => route('home'),
    ]);
})->name('logout');


Route::middleware('auth')->prefix('account')->name('account.')->group(function () {
    Route::get('/', [AccountController::class, 'index'])->name('index');
    Route::get('/orders', [AccountController::class, 'orders'])->name('orders');
    Route::get('/wishlist', [AccountController::class, 'wishlist'])->name('wishlist');
    Route::get('/subscriptions', [AccountController::class, 'subscriptions'])->name('subscriptions');
    Route::get('/wallet', [AccountController::class, 'wallet'])->name('wallet');
    Route::get('/address-book', [AccountController::class, 'addressBook'])->name('address-book');
    Route::get('/email-preferences', [AccountController::class, 'emailPreferences'])->name('email-preferences');
});


// Verify link (auto sent by Laravel)
// Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
//     $request->fulfill();
//     return redirect('/home');
// })->middleware(['auth', 'signed'])->name('verification.verify');

// Resend verification
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');


// Login/Register
Route::post('/auth/popup/login',    [AuthPopupController::class,'login'])->name('auth.popup.login');
Route::post('/auth/popup/register', [AuthPopupController::class,'register'])->name('auth.popup.register');

// Home page
Route::get('/', [HomeController::class, 'index'])->name('home');
//Category Page
Route::get('/category/{slug}', [CategoryController::class, 'show'])->name('category.show');
//Product Page
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('product.show');
// Cart Page
Route::get('/cart',        [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::get('/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');


Route::put('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
// Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

// Thank You page
Route::get('/thankyou', function () {
    return view('frontend.thankyou');
})->name('thankyou');

Route::get('/cart/offcanvas', [CartController::class, 'offcanvas'])->name('cart.offcanvas');

Route::get('/my-orders', [OrderController::class, 'index'])->name('orders.index');



// Wishlist Page
Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
Route::post('/wishlist/add', [WishlistController::class, 'add'])->name('wishlist.add');
Route::delete('/wishlist/remove/{item}', [WishlistController::class, 'remove'])->name('wishlist.remove');


Route::get('/auth/{provider}/redirect', [SocialAuthController::class, 'redirect'])
    ->whereIn('provider', ['google', 'facebook', 'apple'])
    ->name('social.redirect');

Route::get('/auth/{provider}/callback', [SocialAuthController::class, 'callback'])
    ->whereIn('provider', ['google', 'facebook', 'apple'])
    ->name('social.callback');

Route::view('/terms', 'static.terms')->name('terms');
Route::view('/privacy', 'static.privacy')->name('privacy');
Route::view('/ca-privacy', 'static.ca-privacy')->name('ca-privacy');



// Dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    

});


Route::middleware(['auth', 'verified'])->group(function () {
    // Route::get('/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});
// Route::get('/account', function () {
//     return view('account.dashboard');
// })->name('account.dashboard')->middleware('auth');



Route::post('/auth/check-email', [AuthController::class, 'checkEmail'])->name('auth.checkEmail');
Route::post('/auth/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/auth/signup', [AuthController::class, 'signup'])->name('auth.signup');

require __DIR__.'/auth.php';
