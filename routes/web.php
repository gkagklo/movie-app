<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\SerieController;
use App\Http\Controllers\CastController;
use App\Http\Controllers\GenreController;
use App\Livewire\GenreIndex;
use App\Livewire\CastIndex;
use App\Livewire\EpisodeIndex;
use App\Livewire\MovieIndex;
use App\Livewire\SeasonIndex;
use App\Livewire\SerieIndex;
use App\Livewire\TagIndex;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [WelcomeController::class, 'index']);
Route::get('/movies', [MovieController::class, 'index'])->name('movies.index');
Route::get('/series', [SerieController::class, 'index'])->name('series.index');
Route::get('/casts', [CastController::class, 'index'])->name('casts.index');
Route::get('/genre/{slug}', [GenreController::class, 'show'])->name('genre.show');

Route::middleware(['auth:sanctum', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function(){
    Route::get('/', [AdminController::class, 'index'])->name('index');
    Route::get('movies', MovieIndex::class)->name('movies.index');
    Route::get('series', SerieIndex::class)->name('series.index');
    Route::get('series/{serie}/seasons', SeasonIndex::class)->name('seasons.index');
    Route::get('series/{serie}/seasons/{season}/episodes', EpisodeIndex::class)->name('episodes.index');
    Route::get('genres', GenreIndex::class)->name('genres.index');
    Route::get('casts', CastIndex::class)->name('casts.index');
    Route::get('tags', TagIndex::class)->name('tags.index');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        auth()->user()->assignRole('admin');
        return view('dashboard');
    })->name('dashboard');
});
