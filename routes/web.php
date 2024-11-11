<?php

use App\Http\Controllers\CheckController;
use App\Http\Controllers\FriendsController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\UserCheckAccess;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('/test', function () {
        dd($_REQUEST);
    })->name('test');

    Route::get('/dashboard', [FriendsController::class, 'index'])->name('dashboard');
    Route::post('/friend/add', [FriendsController::class, 'addFriend'])->name('addFriend');

    Route::get('/moneybox', [CheckController::class, 'index'])->name('moneybox');
    Route::post('/moneyBox/createNew', [CheckController::class, 'store'])->name('createCheck');

    Route::middleware(UserCheckAccess::class)->group(function () {
        Route::get('/moneybox/{selected?}', [CheckController::class, 'index'])->name('moneybox');
        Route::post('/moneybox/{selected}', [CheckController::class, 'update'])->name('updateCheck');
        Route::delete('/moneyBox/destroy/{selected}', [CheckController::class, 'destroy'])->name('destroyCheck');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
