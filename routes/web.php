<?php

use App\Http\Controllers\DonationController;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\HeroController;
use App\Http\Controllers\SponsorController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::fallback(function () {
    return view('pages.coming');
});
Route::redirect('/home','/donation');

Route::middleware('guest')->group(function(){
    Route::controller(UserController::class)->group(function(){
        Route::get('qwertyuiop','login')->name('login');
        Route::post('qwertyuiop','authenticate')->name('user.authenticate');
    });
    Route::get('',[HeroController::class,'create'])->name('hero.create');
    Route::post('',[HeroController::class,'store'])->name('hero.store');
    Route::get('/hero/cancel',[HeroController::class,'cancel'])->name('hero.cancel');
});
Route::middleware('auth')->group(function(){
    Route::post('/hero/contributor',[HeroController::class,'contributor'])->name('hero.contributor');
    Route::resource('user', UserController::class);
    Route::resource('donation', DonationController::class);
    Route::resource('sponsor', SponsorController::class);
    Route::resource('food', FoodController::class)->except(['show','create']);
    Route::resource('hero', HeroController::class)->except(['show','edit','create','store']);
    Route::get('/hero/faculty/{faculty}',[HeroController::class,'faculty'])->name('hero.faculty');
    Route::get('/hero/backups',[HeroController::class,'backups'])->name('hero.backups');
    Route::get('/hero/restore/{backup}',[HeroController::class,'restore'])->name('hero.restore');
    Route::delete('/hero/trash/{backup}',[HeroController::class,'trash'])->name('hero.trash');
    Route::get('logout',[UserController::class,'logout'])->name('logout');
});
