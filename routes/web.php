<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/book', [BookController::class,'index'])->name('book.index');
Route::get('/book/create', [BookController::class,'create'])->name('book.create');
Route::post('/book/create', [BookController::class,'store']) ;
Route::get('/book/{id}', [BookController::class,'edit'])->name('book.edit');
Route::patch('/buku/{id}/', [BookController::class, 'update'])->name('book.update'); 
Route::delete('/buku/{id}/delete', [BookController::class, 'destroy'])->name('book.destroy'); 

Route::get('/peminjaman',[TransactionController::class,'index']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    
    Route::post('/pinjam/{id}',[TransactionController::class,'store'])->name('transaction.store');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
