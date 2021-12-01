<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

for ($day = 1; $day <= 25; $day++) {
    Route::get("/day-${day}/first", ["App\Http\Controllers\Day${day}Controller", 'first']);
    Route::get("/day-${day}/second", ["App\Http\Controllers\Day${day}Controller", 'second']);
}
