<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Project routes
    Route::resource('projects', \App\Http\Controllers\ProjectController::class);
    
    // Dataset routes
    Route::get('projects/{project}/import', [\App\Http\Controllers\DatasetController::class, 'import'])->name('datasets.import');
    Route::post('projects/{project}/import', [\App\Http\Controllers\DatasetController::class, 'store'])->name('datasets.store');
    Route::get('download-template', [\App\Http\Controllers\DatasetController::class, 'downloadTemplate'])->name('datasets.template');
    
    // Apriori analysis routes
    Route::post('projects/{project}/analyze', [\App\Http\Controllers\AprioriController::class, 'analyze'])->name('apriori.analyze');
    Route::get('projects/{project}/results', [\App\Http\Controllers\AprioriController::class, 'results'])->name('apriori.results');
});

require __DIR__.'/auth.php';
