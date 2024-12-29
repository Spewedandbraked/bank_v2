<?php

use App\Http\Controllers\CheckController;
use App\Http\Controllers\FriendsController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\UserCheckAccess;
use App\Http\Middleware\UserFriendAccess;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('/test', function () {
        dd($_REQUEST);
    })->name('test');
    Route::get('/test', function () {
        function bbb($toexecute, $toexecute2)
        {
            $toexecute('1', '2');
            $toexecute2('3', '4');
        }
        bbb(
            $blockMan = function ($friendRecord, $takenUser) {
                dump($friendRecord, $takenUser);
            },
            $blockMan
        );
    })->name('test');

    Route::get('/dashboard', [FriendsController::class, 'index'])->name('dashboard');
    Route::post('/friend/add', [FriendsController::class, 'addFriend'])->name('addFriend');
    Route::post('/friend/block', [FriendsController::class, 'blockFriend'])->name('blockFriend');

    Route::get('/moneybox', [CheckController::class, 'index'])->name('moneybox');
    Route::post('/moneyBox/createNew', [CheckController::class, 'store'])->name('createCheck');

    Route::middleware(UserCheckAccess::class)->group(function () {
        Route::get('/moneybox/{selected?}', [CheckController::class, 'index'])->name('moneybox');
        Route::post('/moneybox/{selected}', [CheckController::class, 'update'])->name('updateCheck');
        Route::delete('/moneyBox/destroy/{selected}', [CheckController::class, 'destroy'])->name('destroyCheck');
    });
    Route::middleware(UserFriendAccess::class)->group(function () {
        Route::get('/friend/{selected?}', [FriendsController::class, 'index'])->name('viewUser');
        // Route::post('/friend/{selected}', [FriendsController::class, 'update'])->name('updateCheck');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
