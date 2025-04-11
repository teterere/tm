<?php

use App\Http\Controllers\TaskChecklistItemController;
use App\Http\Controllers\TaskCommentController;
use App\Http\Controllers\TaskController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin'       => Route::has('login'),
        'canRegister'    => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion'     => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/uzdevumi', [TaskController::class, 'index'])->name('tasks.index');
    Route::get('/uzdevumi/{taskIdentifier}', [TaskController::class, 'index'])->name('show');

    Route::prefix('uzdevumi/{task}')->name('tasks.')->group(function () {
        Route::patch('/', [TaskController::class, 'update'])->name('update');
        Route::patch('/update-status/{status}', [TaskController::class, 'updateStatus'])->name('update-status');
        Route::patch('/update-priority/{priority}', [TaskController::class, 'updatePriority'])->name('update-priority');

        Route::prefix('birkas')->name('labels.')->group(function () {
            Route::post('/add', [TaskController::class, 'addLabels'])->name('add');
            Route::delete('/remove-all', [TaskController::class, 'removeAllLabels'])->name('remove-all');
            Route::delete('{label}', [TaskController::class, 'removeLabel'])->name('remove');
        });

        Route::prefix('checklist-items')->name('checklist-items.')->group(function () {
            Route::post('/', [TaskChecklistItemController::class, 'store'])->name('store');
            Route::patch('update-order', [TaskChecklistItemController::class, 'updateOrder'])->name('update-order');
            Route::patch('{item}/toggle-complete', [TaskChecklistItemController::class, 'toggleComplete'])->name('toggle-complete');
            Route::patch('{item}', [TaskChecklistItemController::class, 'update'])->name('update');
            Route::delete('/delete-all-for-task', [TaskChecklistItemController::class, 'deleteAllForTask'])->name('delete-all-for-task');
            Route::delete('{item}', [TaskChecklistItemController::class, 'destroy'])->name('delete');
        });

        Route::prefix('comments')->name('comments.')->group(function () {
            Route::post('/', [TaskCommentController::class, 'store'])->name('store');
            Route::patch('/{comment}', [TaskCommentController::class, 'update'])->name('update');
            Route::delete('{comment}', [TaskCommentController::class, 'destroy'])->name('delete');
        });
    });
});
