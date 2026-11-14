<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AiController;

// Главная страница с интерфейсом студии
Route::get('/', [AiController::class, 'index']);

// API роут для генерации
Route::post('/api/v1/generate/text', [AiController::class, 'generate']);