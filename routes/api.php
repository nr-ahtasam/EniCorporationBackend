<?php
use App\Http\Controllers\UserController;
use App\Http\Controllers\NavbarController;

Route::get('/users', [UserController::class, 'index']);
Route::post('/register', [UserController::class, 'register']);
Route::get('/navbar', [NavbarController::class, 'show']);


//transtechquery
//shadcn
