<?php

use Illuminate\Support\Facades\Route;



// Route bawaan ke halaman welcome
Route::get('/', function () {
    return view('welcome');
});
