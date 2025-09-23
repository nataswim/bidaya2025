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
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\ToolController;

// Routes publiques
Route::view('/', 'public.home')->name('home');
Route::view('/about', 'public.about')->name('about');
Route::view('/contact', 'public.contact')->name('contact');


// Routes outils
Route::get('/outils/calculateur-imc', [ToolController::class, 'bmiCalculator'])->name('tools.bmi');
Route::get('/outils/calculateur-masse-grasse', [ToolController::class, 'bodyFatCalculator'])->name('tools.masse-grasse');
Route::get('/outils/calculateur-calories', [ToolController::class, 'calorieCalculator'])->name('tools.calories');
Route::get('/outils/chronometre-natation', [ToolController::class, 'swimmingChronometer'])->name('tools.chronometre');
Route::get('/outils/chronometre-pro', [ToolController::class, 'chronometerPro'])->name('tools.chronometre-pro');
Route::get('/outils/calculateur-vnc', [ToolController::class, 'criticalSwimSpeed'])->name('tools.vnc');
Route::get('/outils/calculateur-fitness', [ToolController::class, 'fitnessCalculator'])->name('tools.fitness');
Route::get('/outils/coherence-cardiaque', [ToolController::class, 'heartCoherence'])->name('tools.coherence-cardiaque');
Route::get('/outils/calculateur-hydratation', [ToolController::class, 'hydrationCalculator'])->name('tools.hydratation');
Route::get('/outils/carte-interactive', [ToolController::class, 'interactiveMap'])->name('tools.carte-interactive');
Route::get('/outils/convertisseur-kcal-macros', [ToolController::class, 'kcalMacroConverter'])->name('tools.kcal-macros');
Route::get('/outils/calculateur-rm-charge-maximale', [ToolController::class, 'onermCalculator'])->name('tools.onermcalculator');
Route::get('/outils/planificateur-course-a-pieds', [ToolController::class, 'runningPlanner'])->name('tools.running-planner');
Route::get('/outils/predicteur-natation', [ToolController::class, 'swimmingPredictor'])->name('tools.swimming-predictor');
Route::get('/outils/planificateur-natation', [ToolController::class, 'swimmingPlanner'])->name('tools.swimming-planner');
Route::get('/outils/zones-cardiaques', [ToolController::class, 'heartRateZones'])->name('tools.heart-rate-zones');
Route::get('/outils/calculateur-tdee', [ToolController::class, 'tdeeCalculator'])->name('tools.tdee-calculator');
Route::get('/outils/planificateur-triathlon', [ToolController::class, 'triathlonPlanner'])->name('tools.triathlon-planner');
Route::get('/outils/efficacite-technique-natation', [ToolController::class, 'swimmingEfficiency'])->name('tools.swimming-efficiency');

// Routes outils par catégories
Route::get('/outils', [ToolController::class, 'index'])->name('tools.index');
Route::get('/outils/categorie/sante-composition-corporelle', [ToolController::class, 'healthBodyComposition'])->name('tools.category.health');
Route::get('/outils/categorie/nutrition-energie', [ToolController::class, 'nutritionEnergy'])->name('tools.category.nutrition');
Route::get('/outils/categorie/performance-cardiaque', [ToolController::class, 'cardiacPerformance'])->name('tools.category.cardiac');
Route::get('/outils/categorie/sports-aquatiques-natation', [ToolController::class, 'aquaticSports'])->name('tools.category.swimming');
Route::get('/outils/categorie/course-endurance', [ToolController::class, 'runningEndurance'])->name('tools.category.running');
Route::get('/outils/categorie/force-musculation', [ToolController::class, 'strengthTraining'])->name('tools.category.strength');
Route::get('/outils/categorie/outils-pratiques', [ToolController::class, 'practicalTools'])->name('tools.category.practical');
Route::get('/outils/categorie/outils-developpement', [ToolController::class, 'developmentTools'])->name('tools.category.development');


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
    
    // NOUVELLE ROUTE pour traiter la mise à jour du profil
    Route::put('profile', [ProfileController::class, 'updateUserProfile'])->name('profile.update');

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

Route::post('/admin/users/{user}/promote', [UserController::class, 'promote'])->name('admin.users.promote');
    Route::post('/admin/users/{user}/demote', [UserController::class, 'demote'])->name('admin.users.demote');


// ========== ROUTES MÉDIAS ==========
    
    // Gestion principale des médias
    Route::get('media', [MediaController::class, 'index'])->name('media.index');
    Route::post('media', [MediaController::class, 'store'])->name('media.store');
    Route::get('media/{media}', [MediaController::class, 'show'])->name('media.show');
    Route::put('media/{media}', [MediaController::class, 'update'])->name('media.update');
    Route::delete('media/{media}', [MediaController::class, 'destroy'])->name('media.destroy');
    
    // API pour sélection des médias (utilisée dans les modals)
    Route::get('media-api', [MediaController::class, 'api'])->name('media.api');
    
    // Gestion des catégories de médias
    Route::get('media-categories', [MediaController::class, 'categories'])->name('media.categories');
    Route::post('media-categories', [MediaController::class, 'storeCategory'])->name('media.categories.store');
    Route::delete('media-categories/{category}', [MediaController::class, 'destroyCategory'])->name('media.categories.destroy');

});