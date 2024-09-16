<?php

use App\Http\Controllers\MovementTypeController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\WalletSharedToController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\ProfileController;


Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return view('welcome');
    });

    Route::resource('currency', CurrencyController::class);
    Route::resource('wallet', WalletController::class);
    Route::resource('movement_type', MovementTypeController::class);
    Route::resource('walletshared', WalletSharedToController::class);
    Route::resource('movement', \App\Http\Controllers\MovementController::class);
    Route::resource('home', \App\Http\Controllers\DashboardController::class);
    Route::resource('/', \App\Http\Controllers\DashboardController::class);

    Route::get('/movement_types/{walletId}', [\App\Http\Controllers\MovementController::class, 'getMovementTypes']);

    Route::get('/profile', [ProfileController::class, 'show'])->name('profile')->middleware('auth');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update')->middleware('auth');


});





Route::get('/logoff', '\App\Http\Controllers\Auth\LoginController@logout');


//Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Auth::routes();

//Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
