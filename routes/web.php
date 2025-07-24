<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RentalController;

Route::get('/', function () {
    return view('rent.data');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/members/data', function () {
    return view('members.data');
});

Route::get('/assets/data', function () {
    return view('assets.data');
});

Route::get('/rent/form', [RentalController::class, 'create'])->name('rent.create');
Route::post('/rent', [RentalController::class, 'store'])->name('rent.store');

Route::get('/sectors/data', function () {
    return view('sectors.data');
});