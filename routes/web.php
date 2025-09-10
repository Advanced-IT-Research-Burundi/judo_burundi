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

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/blog', [BlogController::class, 'index'])->name('blog');
Route::get('/elements', [ElementController::class, 'element'])->name('element');
Route::get('/services', [ServiceController::class, 'index'])->name('service');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
// Routes pour l'administration
Route::prefix('admin')->middleware('auth')->name('admin.')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('categories', CategorieController::class);
    Route::resource('joueurs', JoueurController::class);
    Route::resource('provinces', ProvinceController::class);
    Route::resource('communes', CommuneController::class);
    Route::resource('zones', ZoneController::class);
    Route::resource('quartiers', QuartierController::class);
    Route::resource('typeposts', TypePostController::class);
    Route::resource('posts', PostController::class);
    Route::resource('countries', CountrieController::class);
    
});
