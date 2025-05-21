<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\LinkController;
use App\Http\Controllers\QrCodeController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [LinkController::class, 'index'])->middleware(['auth', 'verified'])->name('link.index');

Route::middleware('auth', 'verified')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('links/store', [LinkController::class, 'store'])->name('links.store');
    Route::get('/links/create', [LinkController::class, 'create'])->name('links.create');

    Route::delete('links/{link}', [LinkController::class, 'destroy'])->name('links.destroy');

    Route::get('/links/{link}/edit', [LinkController::class, 'edit'])->name('links.edit');
    Route::put('/links/{link}', [LinkController::class, 'update'])->name('links.update');

    Route::post('/{shortcut}/verify', [RedirectController::class, 'verifyPassword'])->name('links.verifyPassword');

});



require __DIR__.'/auth.php';

Route::get('/{shortcut}', [\App\Http\Controllers\RedirectController::class, 'redirect'])
->where('shortcut', '[a-zA-Z0-9-_]+');