<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\PostController;

/*
|--------------------------------------------------------------------------
| Espace Public
|--------------------------------------------------------------------------
*/
Route::view('/', 'public.home')->name('home');
Route::view('/about', 'public.about')->name('about');
Route::view('/contact', 'public.contact')->name('contact');
Route::view('/blog', 'public.index')->name('blog.index');
Route::view('/blog/{slug}', 'public.show')->name('blog.show');

/*
|--------------------------------------------------------------------------
| Espace Utilisateur (authentifié)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard utilisateur
    Route::view('/dashboard', 'user.dashboard')->name('user.dashboard');

    // Profil utilisateur
    Route::get('/profile', [ProfileController::class, 'show'])->name('user.profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('user.profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('user.profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('user.profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Espace Administrateur
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified', 'is_admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        // Dashboard admin
        Route::view('/dashboard', 'admin.dashboard')->name('dashboard');

        // CRUD complet pour les ressources admin
        Route::resource('users', UserController::class);
        Route::resource('roles', RoleController::class);
        Route::resource('permissions', PermissionController::class);
        Route::resource('categories', CategoryController::class);
        Route::resource('tags', TagController::class);
        Route::resource('posts', PostController::class);

        // Profil admin (si différent du profil user)
        Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
        Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

require __DIR__.'/auth.php';
