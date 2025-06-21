<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Row;
use App\Http\Controllers\PatientController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(('verified'))->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');
    Route::resource('patients', PatientController::class);
    // Route::get('/patient-details', [PatientController::class, 'show'])->name('patients.show');
    // Route::get('/edit-patient-details', [PatientController::class, 'edit'])->name('patients.edit');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
