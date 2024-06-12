<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\PenerbitController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

// Routes for books
Route::middleware(['auth'])->group(function () {
    Route::get('/book', [BookController::class, 'index'])->name('book.index');
    Route::get('/book/create', [BookController::class, 'create'])->name('book.create');
    Route::post('/book/create', [BookController::class, 'store']);
    Route::get('/book/{id}', [BookController::class, 'edit'])->name('book.edit');
    Route::patch('/book/{id}', [BookController::class, 'update'])->name('book.update');
    Route::delete('/book/{id}/delete', [BookController::class, 'destroy'])->name('book.destroy');
});

// Route for transactions
Route::middleware(['auth'])->group(function () {
    Route::get('/peminjaman', [TransactionController::class, 'index']);
    Route::post('/pinjam/{id}', [TransactionController::class, 'store'])->name('transaction.store');
});

// Routes for profile
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Routes for penerbit
Route::middleware(['auth'])->group(function () {
    Route::get('/penerbit', [PenerbitController::class, 'index'])->name('penerbit.index');
    Route::get('/penerbit/create', [PenerbitController::class, 'create'])->name('penerbit.create');
    Route::post('/penerbit/create', [PenerbitController::class, 'store']);
    Route::get('/penerbit/{id}', [PenerbitController::class, 'edit'])->name('penerbit.edit');
    Route::patch('/penerbit/{id}', [PenerbitController::class, 'update'])->name('penerbit.update');
    Route::delete('/penerbit/{id}/delete', [PenerbitController::class, 'destroy'])->name('penerbit.destroy');
});

// Rute untuk users
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users/create', [UserController::class, 'store']);
    Route::get('/users/{id}', [UserController::class, 'edit'])->name('users.edit');
    Route::patch('/users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}/delete', [UserController::class, 'destroy'])->name('users.destroy');
});

// Route for dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';
