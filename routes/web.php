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
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\EbookController;
use App\Http\Controllers\DownloadCategoryController;
use App\Http\Controllers\DownloadableController;
use App\Http\Controllers\ExercicePublicController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FicheController;
use App\Http\Controllers\FichesCategoryController;
use App\Http\Controllers\PublicFicheController;
use App\Http\Controllers\PublicWorkoutController;
use App\Http\Controllers\WorkoutCategoryController;
use App\Http\Controllers\WorkoutSectionController;
use App\Http\Controllers\WorkoutController;



// ========== ROUTES WORKOUTS PUBLIQUES ==========
Route::prefix('workouts')->name('public.workouts.')->group(function () {
    Route::get('/', [PublicWorkoutController::class, 'index'])->name('index');
    Route::get('/{section}', [PublicWorkoutController::class, 'section'])->name('section');
    Route::get('/{section}/{category}', [PublicWorkoutController::class, 'category'])->name('category');
    Route::get('/{section}/{category}/{workout}', [PublicWorkoutController::class, 'show'])->name('show');
});

// Routes publiques
Route::view('/', 'public.home')->name('home');
Route::view('/about', 'public.about')->name('about');
Route::view('/accessibilite', 'public.accessibility')->name('accessibility');
Route::get('/cookies', [PublicController::class, 'cookies'])->name('cookies');
Route::get('/fonctionnalites', [PublicController::class, 'features'])->name('features');
Route::get('/mentions-legales', [PublicController::class, 'legal'])->name('legal');
Route::get('/politique-confidentialite', [PublicController::class, 'privacy'])->name('privacy');
Route::get('/plans-inscription', [PublicController::class, 'pricing'])->name('pricing');
Route::get('/guide-utilisation', [PublicController::class, 'guide'])->name('guide');

Route::get('/contact', [PublicController::class, 'contact'])->name('contact');
Route::post('/contact', [PublicController::class, 'contactSend'])->name('contact.send');

// Routes publiques pour les eBooks (avant les routes auth)
Route::prefix('ebook')->name('ebook.')->group(function () {
    Route::get('/', [EbookController::class, 'index'])->name('index');
    Route::get('/recherche', [EbookController::class, 'search'])->name('search');
    Route::get('/{category}', [EbookController::class, 'category'])->name('category');
    Route::get('/{category}/{downloadable}', [EbookController::class, 'show'])->name('show');
    Route::get('/{category}/{downloadable}/telecharger', [EbookController::class, 'download'])->name('download');
});

// ========== ROUTES FICHES PUBLIQUES ==========
Route::prefix('fiches')->name('public.fiches.')->group(function () {
    Route::get('/', [PublicFicheController::class, 'index'])->name('index');
    Route::get('/{category}', [PublicFicheController::class, 'category'])->name('category');
    Route::get('/{category}/{fiche}', [PublicFicheController::class, 'show'])->name('show');
});



// Routes publiques pour les exercices
Route::prefix('exercices')->name('exercices.')->group(function () {
    Route::get('/', [ExercicePublicController::class, 'index'])->name('index');
    Route::get('/recherche', [ExercicePublicController::class, 'search'])->name('search');
    Route::get('/{exercice}', [ExercicePublicController::class, 'show'])->name('show');
});


// Routes publiques pour les plans d'entraînement (après les exercices)
Route::prefix('plans')->name('plans.')->group(function () {
    Route::get('/', [\App\Http\Controllers\PlanPublicController::class, 'index'])->name('index');
    Route::get('/{plan}', [\App\Http\Controllers\PlanPublicController::class, 'show'])->name('show');
});

// ========== ROUTES FICHES PUBLIQUES ==========
Route::prefix('fiches')->name('public.fiches.')->group(function () {
    Route::get('/', [PublicFicheController::class, 'index'])->name('index');
    Route::get('/{category}', [PublicFicheController::class, 'category'])->name('category');
    Route::get('/{category}/{fiche}', [PublicFicheController::class, 'show'])->name('show');
});

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

// Routes outils par categories
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


// ROUTES DE PAIEMENTS UTILISATEURS (HORS GROUPE ADMIN)
Route::middleware(['auth'])->group(function () {
    Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
    Route::post('/payments/create-intent', [PaymentController::class, 'createPaymentIntent'])->name('payments.create-intent');
    Route::get('/payments/confirm', [PaymentController::class, 'confirmPayment'])->name('payments.confirm');
    Route::get('/payments/history', [PaymentController::class, 'history'])->name('payments.history');
});




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
    
    // NOUVELLE ROUTE pour traiter la mise A jour du profil
    Route::put('profile', [ProfileController::class, 'updateUserProfile'])->name('profile.update');
// Ajoutez ces routes dans le groupe user existant, après la route profile.update :

// ========== ROUTES ENTRAÎNEMENT UTILISATEUR ==========

// Plans d'entraînement
Route::get('training', [\App\Http\Controllers\User\TrainingController::class, 'index'])->name('training.index');
Route::get('training/mes-plans', [\App\Http\Controllers\User\TrainingController::class, 'mesPlans'])->name('training.mes-plans');
Route::get('training/plans/{plan}', [\App\Http\Controllers\User\TrainingController::class, 'show'])->name('training.show');
Route::get('training/plans/{plan}/cycles/{cycle}', [\App\Http\Controllers\User\TrainingController::class, 'cycle'])->name('training.cycle');
Route::get('training/plans/{plan}/cycles/{cycle}/seances/{seance}', [\App\Http\Controllers\User\TrainingController::class, 'seance'])->name('training.seance');
Route::get('training/exercices/{exercice}', [\App\Http\Controllers\User\TrainingController::class, 'exercice'])->name('training.exercice');

// Actions utilisateur sur les plans
Route::post('training/plans/{plan}/commencer', [\App\Http\Controllers\User\TrainingController::class, 'commencer'])->name('training.commencer');
Route::patch('training/plans/{plan}/statut', [\App\Http\Controllers\User\TrainingController::class, 'updateStatut'])->name('training.update-statut');


});

// Espace Administration
Route::prefix('admin')->middleware(['auth'])->name('admin.')->group(function () {
    Route::view('/', 'dashboard')->name('dashboard');
    
// Gestion des sections de workout
    Route::resource('workout-sections', WorkoutSectionController::class)->parameters([
        'workout-sections' => 'workoutSection'
    ]);
    
    // Gestion des catégories de workout
    Route::resource('workout-categories', WorkoutCategoryController::class)->parameters([
        'workout-categories' => 'workoutCategory'
    ]);
    
    // Gestion des workouts
    Route::resource('workouts', WorkoutController::class);

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

// Gestion des catégories de fiches
    Route::resource('fiches-categories', FichesCategoryController::class);
    
    // Gestion des fiches
Route::resource('fiches', FicheController::class)->parameters([
    'fiches' => 'fiche'
]);
// ========== ROUTES MeDIAS ==========
    
    // Gestion principale des medias
    Route::get('media', [MediaController::class, 'index'])->name('media.index');
    Route::post('media', [MediaController::class, 'store'])->name('media.store');
    Route::get('media/{media}', [MediaController::class, 'show'])->name('media.show');
    Route::put('media/{media}', [MediaController::class, 'update'])->name('media.update');
    Route::delete('media/{media}', [MediaController::class, 'destroy'])->name('media.destroy');
    
    // API pour selection des medias (utilisee dans les modals)
    Route::get('media-api', [MediaController::class, 'api'])->name('media.api');
    
    // Gestion des categories de medias
    Route::get('media-categories', [MediaController::class, 'categories'])->name('media.categories');
    Route::post('media-categories', [MediaController::class, 'storeCategory'])->name('media.categories.store');
    Route::delete('media-categories/{category}', [MediaController::class, 'destroyCategory'])->name('media.categories.destroy');

    Route::post('media/bulk-action', [MediaController::class, 'bulkAction'])->name('media.bulk-action');


// ========== ROUTES ENTRAÎNEMENT ADMIN ==========

// Gestion des exercices
Route::resource('training/exercices', \App\Http\Controllers\Admin\ExerciceController::class)
    ->names('training.exercices');

// Gestion des séries
Route::resource('training/series', \App\Http\Controllers\Admin\SerieController::class)
    ->names('training.series');

// Gestion des séances
Route::resource('training/seances', \App\Http\Controllers\Admin\SeanceController::class)
    ->names('training.seances');

// Gestion des cycles
Route::resource('training/cycles', \App\Http\Controllers\Admin\CycleController::class)
    ->names('training.cycles');

// Gestion des plans
Route::resource('training/plans', \App\Http\Controllers\Admin\PlanController::class)
    ->names('training.plans');

// Gestion des assignations de plans
Route::get('training/plans/{plan}/assignations', [\App\Http\Controllers\Admin\PlanController::class, 'assignations'])
    ->name('training.plans.assignations');
Route::post('training/plans/{plan}/assign-user', [\App\Http\Controllers\Admin\PlanController::class, 'assignUser'])
    ->name('training.plans.assign-user');
Route::delete('training/plans/{plan}/unassign-user/{user}', [\App\Http\Controllers\Admin\PlanController::class, 'unassignUser'])
    ->name('training.plans.unassign-user');
Route::patch('training/plans/{plan}/update-assignation/{user}', [\App\Http\Controllers\Admin\PlanController::class, 'updateAssignation'])
    ->name('training.plans.update-assignation');






    // ROUTES ADMIN PAIEMENTS
    Route::get('payments', [AdminPaymentController::class, 'index'])->name('payments.index');
    Route::post('payments/{payment}/approve', [AdminPaymentController::class, 'approve'])->name('payments.approve');
    Route::post('payments/{payment}/reject', [AdminPaymentController::class, 'reject'])->name('payments.reject');

    // Gestion des categories de telechargement
    Route::resource('download-categories', DownloadCategoryController::class);
    Route::get('download-categories-stats', [DownloadCategoryController::class, 'stats'])->name('download-categories.stats');
    
    // Gestion des telechargements
    Route::resource('downloadables', DownloadableController::class);
    Route::post('downloadables/{downloadable}/duplicate', [DownloadableController::class, 'duplicate'])->name('downloadables.duplicate');
    Route::get('downloadables-stats', [DownloadableController::class, 'stats'])->name('downloadables.stats');
    Route::post('downloadables/bulk-action', [DownloadableController::class, 'bulkAction'])->name('downloadables.bulk-action');
});