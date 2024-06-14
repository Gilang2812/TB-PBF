<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\DetailTransactionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\PenerbitController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DendaController;

Route::get('/', function () {
    return view('auth.login');
});

// Routes for books
Route::get('/book/user  ', [BookController::class, 'indexClient'])->name('book.user.index');
Route::middleware(['auth'])->group(function () {
    Route::get('/book', [BookController::class, 'index'])->name('book.index');
    Route::get('/book/create', [BookController::class, 'create'])->name('book.create');
    Route::post('/book/create', [BookController::class, 'store']);
    Route::get('/book/{id}', [BookController::class, 'edit'])->name('book.edit');
    Route::patch('/book/{id}', [BookController::class, 'update'])->name('book.update');
    Route::delete('/book/{id}/delete', [BookController::class, 'destroy'])->name('book.destroy');
});

// Routes for denda
Route::middleware(['auth'])->group(function () {
    Route::get('/denda', [DendaController::class,'index'])->name('denda.index');
    Route::get('/denda/create', [DendaController::class,'create'])->name('denda.create');
    Route::post('/denda/create', [DendaController::class,'store']);
    Route::get('/denda/{id}', [DendaController::class,'edit'])->name('denda.edit');
    Route::patch('/denda/{id}', [DendaController::class, 'update'])->name('denda.update'); 
    Route::delete('/denda/{id}/delete', [DendaController::class, 'destroy'])->name('denda.destroy');
});

// Routes for transactions
Route::middleware(['auth'])->group(function () {
    Route::get('/peminjaman', [TransactionController::class,'index'])->name('pinjaman.index.admin');
    Route::get('/pinjaman', [TransactionController::class,'indexClient'])->name('pinjaman.index.user');
    Route::patch('/pinjaman/{id}', [TransactionController::class,'update'])->name('pinjaman.update'); 
    Route::get('/history/user', [TransactionController::class,'showUser'])->name('pinjaman.history.user');
    Route::get('/history', [TransactionController::class,'showAdmin'])->name('pinjaman.history.admin');
    Route::delete('/pinjaman/{nomor_buku}/{nomor_peminjaman}', [DetailTransactionController::class,'cancelAction'])->name('pinjaman.cancel.user');
    Route::patch('/pinjaman/{nomor_peminjaman}/{nomor_buku}/accept', [DetailTransactionController::class,'acceptRequest'])->name('pinjaman.accept');
    Route::patch('/pinjaman/{nomor_peminjaman}/{nomor_buku}/reject', [DetailTransactionController::class,'rejectRequest'])->name('pinjaman.reject');
    Route::patch('/pinjaman/{nomor_peminjaman}/{nomor_buku}/return', [DetailTransactionController::class,'returnRequest'])->name('pinjaman.return');
    Route::post('/pinjam/{id}', [TransactionController::class, 'store'])->name('transaction.store');
});

// Routes for profile
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Email verification routes
Route::middleware(['auth'])->group(function () {
    Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        return redirect('/profile');
    })->middleware('signed')->name('verification.verify');

    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('message', 'Verification link sent!');
    })->middleware('throttle:6,1')->name('verification.send');
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

// Routes for users
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users/create', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{id}', [UserController::class, 'edit'])->name('users.edit');
    Route::patch('/users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}/delete', [UserController::class, 'destroy'])->name('users.destroy');
});

// Route for dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';
