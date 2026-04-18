<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/my-tasks', [TaskController::class, 'index'])->name('my_tasks');
    Route::post('/my-tasks/store', [TaskController::class, 'task_store'])->name('my_task_store');
    Route::put('/tasks-update/{id}', [TaskController::class, 'task_update'])->name('my_task_update');
    Route::delete('/tasks-destroy/{id}', [TaskController::class, 'task_destroy'])->name('my_task_destroy');
    Route::patch('/tasks/{id}/update-status', [TaskController::class, 'status_update'])->name('task.updateStatus');
});

require __DIR__.'/auth.php';
