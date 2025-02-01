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

Route::get('/tasks/{task}', [TaskController::class, 'show'])->name('tasks.show');
Route::post('/tasks/{task}/checklist-items', [TaskChecklistItemController::class, 'store'])->name('tasks.checklist-items.store');
Route::patch('/tasks/{task}/checklist-items/update-order', [TaskChecklistItemController::class, 'updateOrder'])->name('tasks.checklist-items.update-order');
Route::patch('/tasks/{task}/checklist-items/{item}/toggle-complete', [TaskChecklistItemController::class, 'toggleComplete'])->name('tasks.checklist-items.toggle-complete');
Route::patch('/tasks/{task}/checklist-items/{item}', [TaskChecklistItemController::class, 'update'])->name('tasks.checklist-items.update');
Route::delete('/tasks/{task}/checklist-items/{item}', [TaskChecklistItemController::class, 'destroy'])->name('tasks.checklist-items.delete');
