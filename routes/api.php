<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\AuthorBookController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\OrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::resource('books', BookController::class)->only(['index', 'show']);
Route::resource('authors.books', AuthorBookController::class);

// Ensure frontend requests are stateful
Route::middleware([EnsureFrontendRequestsAreStateful::class])->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    })->middleware('auth:sanctum');
});

// Protected routes for authenticated users (both admin and customer)
Route::middleware(['auth:sanctum'])->group(function () {
    // Profile and logout for authenticated users
    Route::get('/profile', function (Request $request) {
        return auth()->user();
    });
    Route::post('/logout', [AuthController::class, 'logout']);

    // Admin routes
    Route::middleware(['role:admin'])->group(function () {
        Route::resource('books', BookController::class)->only(['store', 'destroy', 'update']);
        Route::resource('orders', OrderController::class)->only(['destroy', 'update', 'show', 'index']);
    });

    // Customer routes
    Route::middleware(['role:customer'])->group(function () {
        Route::resource('orders', OrderController::class)->only(['store', 'show', 'index']);
    });
});
