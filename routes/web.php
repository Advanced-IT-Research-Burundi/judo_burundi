<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\admin\JoueurController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\ProvinceController;
use App\Http\Controllers\admin\PostController;
use App\Http\Controllers\admin\CommuneController;
use App\Http\Controllers\admin\ZoneController;
use App\Http\Controllers\admin\QuartierController;
use App\Http\Controllers\admin\CountrieController;
use App\Http\Controllers\admin\GalleryImageController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\GalerieController;
use App\Http\Controllers\admin\EquipeController;
use App\Http\Controllers\admin\MembreController;
use App\Http\Controllers\admin\ClubController;
use App\Http\Controllers\admin\CompetitionController;
use App\Http\Controllers\CompetitionController as ControllersCompetitionController;
use App\Http\Controllers\CompetitionsController;

// Routes publiques
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/competitions', [CompetitionsController::class, 'index'])->name('competitions');
Route::get('/blog', [BlogController::class, 'index'])->name('blog');
Route::get('/galerie', [App\Http\Controllers\GalerieController::class, 'index'])->name('galerie');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::get('/actualites/{post}', [BlogController::class, 'show'])->name('actualites');

// Routes d'authentification
require __DIR__ . '/auth.php';

// Routes de profil
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('membres', MembreController::class);
    Route::get('membres/{membre}/export', [MembreController::class, 'exportPdf'])->name('joueurs.export');
    Route::resource('posts', PostController::class);
    // Route::patch('posts/{post}/toggle-status', [PostController::class, 'toggleStatus'])->name('posts.toggle-status');
    // Route::get('posts/{post}/preview', [PostController::class, 'preview'])->name('posts.preview');
    Route::resource('gallery', GalleryImageController::class);
    Route::resource('equipes', EquipeController::class);
    Route::resource('joueurs', JoueurController::class);
    Route::resource('clubs', ClubController::class);
    Route::resource('competitions', CompetitionController::class);


    // API Routes for AJAX calls
    Route::prefix('api')->name('api.')->group(function () {
        Route::get('stats', [DashboardController::class, 'getStats'])->name('stats');
        Route::get('joueurs/search', [JoueurController::class, 'search'])->name('joueurs.search');
        Route::get('posts/search', [PostController::class, 'search'])->name('posts.search');
    });
});

Route::post('/inscription', [App\Http\Controllers\HomeController::class, 'storeInscription'])->name('inscription.store');
// Localisation
Route::resource('countries', CountrieController::class);
Route::resource('provinces', ProvinceController::class);
Route::resource('communes', CommuneController::class);
Route::resource('zones', ZoneController::class);
Route::resource('quartiers', QuartierController::class);
