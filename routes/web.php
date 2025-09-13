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
    Route::get('/users', [ChatController::class, 'users'])->name('admin.users');
    Route::get('/projects', [ChatController::class, 'projects'])->name('admin.projects');
    Route::get('/security', [ChatController::class, 'security'])->name('admin.security');
    
    // Database viewer routes
    Route::get('/database', [App\Http\Controllers\DatabaseController::class, 'index'])->name('admin.database');
    Route::get('/database/stats', [App\Http\Controllers\DatabaseController::class, 'stats'])->name('admin.database.stats');
    Route::get('/database/table/{table}', [App\Http\Controllers\DatabaseController::class, 'table'])->name('admin.database.table');
});

// Chat API endpoint
Route::post('/chat', [ChatController::class, 'chat'])->name('chat.send');

// History and other routes
Route::get('/history', [ChatController::class, 'history'])->name('chat.history');
Route::get('/settings', [ChatController::class, 'settings'])->name('chat.settings');
