<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\Backend\Auth\AuthController;

    Route::get('login', [AuthController::class,'getLogin'])->name('login');

Route::group(['as'=> 'auth.'], function () {
    Route::get('signup', [AuthController::class,'getSignUp'])->name('signup.get');
    Route::post('signup', [AuthController::class,'signup'])->name('signup.post');
    
    Route::post('login', [AuthController::class,'login'])->name('login.post');

    Route::group(['middleware'=> 'admin'], function () {
        Route::post('logout', [AuthController::class,'logout'])->name('logout.post');
        Route::get('reset-password', [AuthController::class,'getResetPasswordForm'])->name('reset.get');
        Route::post('reset-password', [AuthController::class,'resetPassword'])->name('reset.post');

    });

});