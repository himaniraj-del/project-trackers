<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminDashboardController;

Route::get('/', function(){ return redirect()->route('dashboard'); });

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class,'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('projects', ProjectController::class);
     Route::post('projects/{project}/tasks', [TaskController::class,'store'])->name('projects.tasks.store');
    Route::match(['put','patch'],'tasks/{task}', [TaskController::class,'update'])->name('tasks.update');
    Route::delete('tasks/{task}', [TaskController::class,'destroy'])->name('tasks.destroy');
    Route::post('/tasks/{id}/status', [TaskController::class, 'updateStatus'])->name('tasks.updateStatus');

});

Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])
    ->middleware(['auth', 'checkrole:admin'])
    ->name('admin.dashboard');






require __DIR__.'/auth.php';
