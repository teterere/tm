<?php

use App\Http\Controllers\DemoAccountController;
use App\Http\Controllers\ImageUploadController;
use App\Http\Controllers\TaskChecklistItemController;
use App\Http\Controllers\TaskCommentController;
use App\Http\Controllers\TaskController;
use App\Http\Middleware\EnsureDemoSessionIsValid;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('AboutProject');
})->name('home');

Route::get('/par-izstradataju', function () {
    return Inertia::render('AboutDeveloper');
})->name('about-developer');

Route::post('/demo-konts', [DemoAccountController::class, 'login'])->name('demo.login');

Route::middleware([
    'auth',
    EnsureDemoSessionIsValid::class
])->group(function () {
    Route::get('/uzdevumi', [TaskController::class, 'index'])->name('tasks.index');
    Route::post('/uzdevumi', [TaskController::class, 'store'])->name('tasks.store');
    Route::get('/uzdevumi/{taskIdentifier}', [TaskController::class, 'index'])->name('tasks.show');

    Route::post('/upload-image', [ImageUploadController::class, 'upload'])->name('upload-image');

    Route::prefix('uzdevumi/{task}')->name('tasks.')->group(function () {
        Route::patch('/', [TaskController::class, 'update'])->name('update');
        Route::delete('/', [TaskController::class, 'destroy'])->name('delete');
        Route::patch('/update-status/{status}', [TaskController::class, 'updateStatus'])->name('update-status');
        Route::patch('/update-priority/{priority}', [TaskController::class, 'updatePriority'])->name('update-priority');

        Route::prefix('etiketes')->name('labels.')->group(function () {
            Route::post('/add', [TaskController::class, 'addLabels'])->name('add');
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
            Route::get('/', [TaskCommentController::class, 'index'])->name('index');
            Route::post('/', [TaskCommentController::class, 'store'])->name('store');
            Route::patch('/{comment}', [TaskCommentController::class, 'update'])->name('update');
            Route::delete('{comment}', [TaskCommentController::class, 'destroy'])->name('delete');
        });
    });
});
