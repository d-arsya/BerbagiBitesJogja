<?php

use App\Http\Controllers\DonationController;
use App\Http\Controllers\HeroController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::controller(UserController::class)->group(function(){
    Route::get('qwertyuiop','login')->name('login');
    Route::get('logout','logout')->name('logout');
    Route::post('qwertyuiop','authenticate')->name('user.authenticate');
});
Route::resource('user', UserController::class)->middleware('auth');
Route::resource('donation', DonationController::class)->middleware('auth');
Route::get('',[HeroController::class,'create'])->name('hero.create');
Route::post('',[HeroController::class,'store'])->name('hero.store');
Route::resource('hero', HeroController::class)->except(['edit','create','store'])->middleware('auth');
