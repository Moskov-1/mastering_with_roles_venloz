<?php

use Illuminate\Support\Facades\Route;
Route::get('/{page?}', function ($page = null) {
    return redirect()->route('backend.dashboard.index');
})->where('page', 'home|index');

require_once __DIR__ .'/auth.php';

