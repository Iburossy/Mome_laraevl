<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnnonceController;
use App\Http\Controllers\CategorieController;

// Routes publiques
Route::get('/', [AnnonceController::class, 'indexPublic'])->name('home');
Route::get('/public-annonces/{id}', [AnnonceController::class, 'showPublic'])->name('annonces.showPublic');

// Routes protégées par authentification
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['verified'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('annonces', AnnonceController::class);
    Route::resource('categories', CategorieController::class);
});

// Route pour la page "À propos"
Route::view('/about', 'about')->name('about');

// Route pour la page "Contact"
Route::view('/contact', 'contact')->name('contact');

require __DIR__.'/auth.php';
