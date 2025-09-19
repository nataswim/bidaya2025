<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController as AdminProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PublicController;

// Routes publiques
Route::view('/', 'public.home')->name('home');
Route::view('/about', 'public.about')->name('about');
Route::view('/contact', 'public.contact')->name('contact');

// Routes dynamiques pour les articles
Route::get('/articles', [PublicController::class, 'index'])->name('public.index');
Route::get('/articles/{post:slug}', [PublicController::class, 'show'])->name('public.show');

require __DIR__.'/auth.php';

// Dashboard avec redirection intelligente
Route::middleware(['auth'])->get('/dashboard', function () {
    $user = auth()->user();
    
    if ($user->hasRole('admin')) {
        return redirect()->route('admin.dashboard');
    }
    
    return redirect()->route('user.dashboard');
})->name('dashboard');

// Espace Utilisateur
Route::middleware(['auth'])->prefix('user')->name('user.')->group(function () {
    Route::view('/dashboard', 'user.dashboard')->name('dashboard');
    Route::view('/', 'user.index')->name('index');
    Route::view('/show', 'user.show')->name('show');
    Route::view('profile/edit', 'user.profile.edit')->name('profile.edit');
});

// Espace Administration
Route::prefix('admin')->middleware(['auth'])->name('admin.')->group(function () {
    Route::view('/', 'dashboard')->name('dashboard');
    
    Route::resource('categories', CategoryController::class);
    Route::resource('permissions', PermissionController::class);
    Route::resource('posts', PostController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('tags', TagController::class);
    Route::resource('users', UserController::class);

    Route::get('profile', [AdminProfileController::class, 'show'])->name('profile.show');
    Route::get('profile/edit', [AdminProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('profile', [AdminProfileController::class, 'update'])->name('profile.update');
    Route::delete('profile', [AdminProfileController::class, 'destroy'])->name('profile.destroy');
});