<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\DetailTransactionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DendaController;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/book', [BookController::class,'index'])->name('book.index');
Route::get('/book/create', [BookController::class,'create'])->name('book.create');
Route::post('/book/create', [BookController::class,'store']) ;
Route::get('/book/{id}', [BookController::class,'edit'])->name('book.edit');
Route::patch('/buku/{id}/', [BookController::class, 'update'])->name('book.update'); 
Route::delete('/buku/{id}/delete', [BookController::class, 'destroy'])->name('book.destroy'); 

Route::get('/denda', [DendaController::class,'index'])->name('denda.index');
Route::get('/denda/create', [DendaController::class,'create'])->name('denda.create');
Route::post('/denda/create', [DendaController::class,'store']) ;
Route::get('/denda/{id}', [DendaController::class,'edit'])->name('denda.edit');
Route::patch('/denda/{id}/', [DendaController::class, 'update'])->name('denda.update'); 
Route::delete('/denda/{id}/delete', [DendaController::class, 'destroy'])->name('denda.destroy'); 

Route::get('/peminjaman',[TransactionController::class,'index']);
Route::get('/peminjaman',[TransactionController::class,'index'])->name('pinjaman.index.admin');
Route::get('/pinjaman',[TransactionController::class,'indexClient'])->name('pinjaman.index.user');
Route::patch('/pinjaman/{id}',[TransactionController::class,'update'])->name('pinjaman.update'); 
Route::get('/history/user',[TransactionController::class,'showUser'])->name('pinjaman.history.user');
Route::get('/history',[TransactionController::class,'showAdmin'])->name('pinjaman.history.admin');
Route::delete('/pinjaman/{nomor_buku}/{nomor_peminjaman}',[DetailTransactionController::class,'cancelAction'])->name('pinjaman.cancel.user');
Route::patch('/pinjaman/{nomor_peminjaman}/{nomor_buku}/accept',[DetailTransactionController::class,'acceptRequest'])->name('pinjaman.accept');
Route::patch('/pinjaman/{nomor_peminjaman}/{nomor_buku}/reject',[DetailTransactionController::class,'rejectRequest'])->name('pinjaman.reject');
Route::patch('/pinjaman/{nomor_peminjaman}/{nomor_buku}/return',[DetailTransactionController::class,'returnRequest'])->name('pinjaman.return');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    
    Route::post('/pinjam/{id}',[TransactionController::class,'store'])->name('transaction.store');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware(['auth'])->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/profile');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');


require __DIR__.'/auth.php';
