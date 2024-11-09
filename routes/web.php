<?php

use App\Http\Controllers\CheckController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\UserCheckAccess;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {

// заметка себе: если однажды будет нужда сделать демонстративную
// главную страницу - я ее сделаю, но в моей (очевидно не адекватной)
// голове ИДЕАЛЬНЫЙ сайт - тот, на котором сразу регистрацию в лицо пихают (типо вк!)
// я добавлю ¨главную¨ страницу в будущем, если сочту необходимым повыпендриваться

// на данный момент ¨главная страница¨ будет переадресовывться на другие маршруты

//     return view('welcome');
// });

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        // повезло - мидлварчик guest отправляет не абы куда, а в 
        // name('dashboard')
        // интересно где настраивается  этот редирект?

        return view('dashboard');
    })->name('dashboard');

    Route::post('/test', function () {
        dd($_REQUEST);
    })->name('test');

    Route::get('/moneybox', [CheckController::class, 'index'])->name('moneybox');
    Route::post('/moneyBox/createNew', [CheckController::class, 'store'])->name('createCheck');

    Route::middleware(UserCheckAccess::class)->group(function () {
        Route::get('/moneybox/{selected?}', [CheckController::class, 'index'])->name('moneybox');
        Route::delete('/moneyBox/destroy/{selected}', [CheckController::class, 'destroy'])->name('destroyCheck');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
