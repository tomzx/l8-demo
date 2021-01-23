<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function() {
    return view('swagger');
});

Route::get('/swagger.yaml', function() {
    return view('swagger.definition');
});
