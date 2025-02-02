<?php

use App\Http\Controllers\TaskChecklistItemController;
use App\Http\Controllers\TaskController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [TaskController::class, 'index'])->name('dashboard');
});

Route::prefix('tasks/{task}')->name('tasks.')->group(function () {
    Route::get('/', [TaskController::class, 'show'])->name('show');

    Route::prefix('checklist-items')->name('checklist-items.')->group(function () {
        Route::post('/', [TaskChecklistItemController::class, 'store'])->name('store');
        Route::patch('update-order', [TaskChecklistItemController::class, 'updateOrder'])->name('update-order');
        Route::patch('{item}/toggle-complete', [TaskChecklistItemController::class, 'toggleComplete'])->name('toggle-complete');
        Route::patch('{item}', [TaskChecklistItemController::class, 'update'])->name('update');
        Route::delete('{item}', [TaskChecklistItemController::class, 'destroy'])->name('delete');
    });
});
