<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

// Register a new user
Route::post('register', function (Request $request) {
    // Validate the request data
    // Ensure the user is authenticated
    $request->validate([
        'name' => 'required|string',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6|string|confirmed',
    ]);
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
    ]);
    return response()->json($user, 201);
});

// Login a user and return a token
Route::post('login', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);
    if (Auth::attempt($request->only('email', 'password'))) {
        $user = User::where('id',Auth::user()->id)->first();
        return response()->json(['token' => $user->createToken('localshop')->plainTextToken]);
    }
    return response()->json(['message' => 'Invalid credentials'], 401);
});

// Logout the authenticated user and revoke the token
Route::post('logout', function (Request $request) {
    $request->user()->tokens->each(function ($token) {
        $token->delete();
    });
    return response()->json(['message' => 'Logged out successfully']);
});

// Your protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/products', [ProductController::class, 'index']);
    Route::post('/products', [ProductController::class, 'store']);
    Route::get('/products/{product}', [ProductController::class, 'show']);
    Route::put('/products/{product}', [ProductController::class, 'update']);
    Route::delete('/products/{product}', [ProductController::class, 'destroy']);
    Route::get('/products/search', [ProductController::class, 'search']);
});





