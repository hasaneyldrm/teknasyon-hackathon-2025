<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;

// Default route - redirect to admin chat
Route::get('/', function () {
    return redirect('/admin');
});

// Old chat interface (keep for compatibility)
Route::get('/old', [ChatController::class, 'index'])->name('chat.index');

// Admin Panel Routes
Route::prefix('admin')->group(function () {
    Route::get('/', [ChatController::class, 'admin'])->name('admin.chat');
    Route::get('/dashboard', [ChatController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/dashboard/data', [ChatController::class, 'dashboardData'])->name('admin.dashboard.data');
    Route::get('/users', [ChatController::class, 'users'])->name('admin.users');
    Route::get('/projects', [ChatController::class, 'projects'])->name('admin.projects');
    Route::get('/security', [ChatController::class, 'security'])->name('admin.security');
    
    // User CRUD Routes
    Route::get('/users/create', [ChatController::class, 'createUser'])->name('admin.users.create');
    Route::post('/users', [ChatController::class, 'storeUser'])->name('admin.users.store');
    Route::get('/users/{id}', [ChatController::class, 'showUser'])->name('admin.users.show');
    Route::get('/users/{id}/edit', [ChatController::class, 'editUser'])->name('admin.users.edit');
    Route::put('/users/{id}', [ChatController::class, 'updateUser'])->name('admin.users.update');
    Route::delete('/users/{id}', [ChatController::class, 'destroyUser'])->name('admin.users.destroy');
    
    // Project CRUD Routes
    Route::get('/projects/create', [ChatController::class, 'createProject'])->name('admin.projects.create');
    Route::post('/projects', [ChatController::class, 'storeProject'])->name('admin.projects.store');
    Route::get('/projects/{id}', [ChatController::class, 'showProject'])->name('admin.projects.show');
    Route::get('/projects/{id}/edit', [ChatController::class, 'editProject'])->name('admin.projects.edit');
    Route::put('/projects/{id}', [ChatController::class, 'updateProject'])->name('admin.projects.update');
    Route::delete('/projects/{id}', [ChatController::class, 'destroyProject'])->name('admin.projects.destroy');
    
    // Settings and History Routes
    Route::get('/settings', [ChatController::class, 'settings'])->name('admin.settings');
    Route::post('/settings', [ChatController::class, 'updateSettings'])->name('admin.settings.update');
    Route::get('/history', [ChatController::class, 'history'])->name('admin.history');
});

// Chat API endpoint
Route::post('/chat', [ChatController::class, 'chat'])->name('chat.send');

// History and other routes
Route::get('/history', [ChatController::class, 'history'])->name('chat.history');
Route::get('/settings', [ChatController::class, 'settings'])->name('chat.settings');
