<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\AuthorBookController;
use App\Http\Controllers\BookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;

Route::middleware([EnsureFrontendRequestsAreStateful::class])->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/register', [AuthController::class, 'register']);
});


Route::post('/login', [AuthController::class, 'login']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::resource('books', BookController::class);
// Route::resource('/books/{id}', BookController::class);

// Route::get('/authors/{id}/books', [AuthorBookController::class, 'index'])->name('authors.books.index');
Route::resource('authors.books', AuthorBookController::class);
