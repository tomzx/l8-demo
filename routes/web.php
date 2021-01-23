<?php

use App\Http\Controllers\PalindromeController;
use Illuminate\Support\Facades\Route;

Route::prefix('api/v1')->group(function () {
    Route::resource('palindromes', PalindromeController::class);
});

