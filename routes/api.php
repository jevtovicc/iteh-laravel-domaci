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

// Ensure frontend requests are stateful
Route::middleware([EnsureFrontendRequestsAreStateful::class])->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    })->middleware('auth:sanctum');
});

// Protected routes for authenticated users
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/profile', function (Request $request) {
        return auth()->user();
    });

    Route::post('/logout', [AuthController::class, 'logout']);

    // CRUD operations for books (only for authenticated users)
    Route::resource('books', BookController::class)->only(['update', 'store', 'destroy']);


    Route::resource('orders', OrderController::class)->only(['update', 'store', 'destroy']);
});

// Routes for books accessible to all users (both authenticated and non-authenticated)
Route::resource('books', BookController::class)->only(['index', 'show']);

Route::resource('orders', OrderController::class)->only(['index', 'show']);

// Nested resource route for authors and their books
Route::resource('authors.books', AuthorBookController::class);
