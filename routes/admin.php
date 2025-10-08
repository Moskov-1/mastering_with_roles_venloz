<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\Web\Backend\FaqController;
use App\Http\Controllers\Web\Backend\ProjectController;
use App\Http\Controllers\Web\Backend\SiteController;
use Illuminate\Support\Facades\Route;

Route::group([ 'as'=>'backend.', 'middleware'=> ['admin']], function () {
    Route::get('/', [SiteController::class,'index'])->name('dashboard.index');
    Route::resource('project', ProjectController::class)->except(['show']);

    Route::group(['as'=>'feature.'], function(){
        Route::post('faq/status/{id}', [FaqController::class,'status'])->name('faq.status');
        Route::resource('faq', FaqController::class)->except(['show']);
    });


    Route::post('page/status/{id}', [PageController::class,'status'])->name('page.status');
    Route::resource('page', PageController::class)->except(['show']);

    
    require_once __DIR__ .'/settings.php';
});
