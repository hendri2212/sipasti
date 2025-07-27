<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\InstitutionController;
use App\Http\Controllers\AssetController;

// Hanya guest yang bisa ke login
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'show'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

// Logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


// Semua route rent butuh autentikasi
Route::middleware('auth')->group(function () {
    Route::get('/', [RentalController::class, 'index'])->name('rent.index');
    Route::get('/rent/form', [RentalController::class, 'create'])->name('rent.create');
    Route::post('/rent', [RentalController::class, 'store'])->name('rent.store');
    Route::get('/rent/{rentalAsset}', [RentalController::class, 'show'])->name('rent.show');
    Route::get('/rent/{rentalAsset}/approve', [RentalController::class, 'approve'])->name('rent.approve');
    Route::put('/rent/{rentalAsset}', [RentalController::class, 'update'])->name('rent.update');
    Route::get('/rent/{rentalAsset}/cancel', [RentalController::class, 'cancel'])->name('rent.cancel');
    Route::get('/rent/{rentalAsset}/change', [RentalController::class, 'change'])->name('rent.change');
    Route::get('/rent/events/{rentalAsset}', [RentalController::class, 'byAssetId'])->name('rent.events');
    
    Route::get('/members/data', [MemberController::class, 'index'])->name('members.data');

    Route::get('/users/role', function () {
        // Restrict access to super_admin only
        abort_if(auth()->user()->role !== 'super_admin', 403);
        return view('users.role');
    })->name('users.role');

    Route::post('/institutions', [InstitutionController::class, 'store'])->name('institutions.store');
    Route::get('/assets/data', [AssetController::class, 'index'])->name('assets.data');
});



Route::get('/sectors/data', function () {
    return view('sectors.data');
});