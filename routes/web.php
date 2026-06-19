<?php

use App\Http\Controllers\DirectorController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


//Route::get('/directors',[DirectorController::class,'index'])->name('directors.index');

//Route::get('/directors/create',[DirectorController::class,'create'])->name('directors.create');
//Route::post('/directors',[DirectorController::class,'store'])->name('directors.store');

//Route::get('/directors/{director}', [DirectorController::class,'show'])->name('directors.show');

require __DIR__.'/auth.php';
