<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;

/*
|--------------------------------------------------------------------------
| API Routes for Mobile App
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your mobile application.
| These routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group.
|
*/

// API Routes for external usage (Mobile App)
// User Management
Route::post('/users', [ChatController::class, 'createUserAPI'])->name('api.users.create');
Route::get('/users/{uuid}', [ChatController::class, 'getUserAPI'])->name('api.users.get');

// Chat API
Route::post('/chat', [ChatController::class, 'chatAPI'])->name('api.chat');
