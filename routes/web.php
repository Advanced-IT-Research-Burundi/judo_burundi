<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\admin\CategorieController;
use App\Http\Controllers\admin\JoueurController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\ProvinceController;
use App\Http\Controllers\admin\PostController;
use App\Http\Controllers\admin\TypePostController;
use App\Http\Controllers\admin\CommuneController;
use App\Http\Controllers\admin\ZoneController;
use App\Http\Controllers\admin\QuartierController;
use App\Http\Controllers\ElementController;
use App\Http\Controllers\admin\CountrieController;
use App\Http\Controllers\ServiceController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Routes publiques
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact/submit', [ContactController::class, 'submit'])->name('contact.submit');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/blog', [BlogController::class, 'index'])->name('blog');
Route::get('/elements', [ElementController::class, 'element'])->name('element');
Route::get('/services', [ServiceController::class, 'index'])->name('service');

// Routes d'authentification
require __DIR__ . '/auth.php';

// Routes de profil
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Routes d'administration
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    
    // API Stats pour le dashboard
    Route::get('/api/stats', [DashboardController::class, 'apiStats'])->name('api.stats');
    Route::get('/api/entity-stats/{entity}', [DashboardController::class, 'entityStats'])->name('api.entity.stats');

    // Posts
    Route::resource('posts', PostController::class);
    Route::delete('posts/{post}/remove-image', [PostController::class, 'removeImage'])->name('posts.removeImage');
    Route::post('posts/bulk-delete', [PostController::class, 'bulkDelete'])->name('posts.bulkDelete');

    // Catégories
    Route::resource('categories', CategorieController::class);
    
    // Types de posts
    Route::resource('type-posts', TypePostController::class);

    // Joueurs
    Route::resource('joueurs', JoueurController::class);
    Route::post('joueurs/bulk-delete', [JoueurController::class, 'bulkDelete'])->name('joueurs.bulkDelete');
    Route::get('joueurs/export', [JoueurController::class, 'export'])->name('joueurs.export');

    // Localisation
    Route::resource('countries', CountrieController::class);
    Route::resource('provinces', ProvinceController::class);
    Route::resource('communes', CommuneController::class);
    Route::resource('zones', ZoneController::class);
    Route::resource('quartiers', QuartierController::class);
});

// Routes de fallback pour les erreurs 404
// Route::fallback(function () {
//     if (request()->is('admin/*')) {
//         return response()->view('admin.errors.404', [], 404);
//     }
//     return response()->view('errors.404', [], 404);
// });