
<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AuthController; // Ensure AuthController exists in this namespace
use Inertia\Inertia;

Route::get('/posts', [PostController::class, 'index']);


// Route สำหรับ Authentication
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->get('/user', [AuthController::class, 'user']);
Route::middleware('auth:sanctum')->post('logout', [AuthController::class, 'logout']);
