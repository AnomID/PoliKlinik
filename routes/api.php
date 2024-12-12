<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Definisikan rute API Anda di sini
Route::middleware('api')->get('/user', function (Request $request) {
    return $request->user();
});
