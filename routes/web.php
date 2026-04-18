<?php

use App\Http\Controllers\DashboardController;
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
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/export-pdf', [DashboardController::class, 'downloadPDF'])->name('tasks.downloadPDF');


    Route::get('/all-tasks', [TaskController::class, 'all_tasks'])->name('all_tasks');
    // My Tasks Routes
    Route::get('/my-tasks', [TaskController::class, 'index'])->name('my_tasks');
    Route::post('/my-tasks/store', [TaskController::class, 'task_store'])->name('my_task_store');
    Route::put('/my-tasks/update/{id}', [TaskController::class, 'task_update'])->name('my_task_update');
    Route::delete('/my-tasks/destroy/{id}', [TaskController::class, 'task_destroy'])->name('my_task_destroy');
    Route::patch('/my-status-update/{id}', [TaskController::class, 'status_update'])->name('my_task.updateStatus');
});

require __DIR__.'/auth.php';
