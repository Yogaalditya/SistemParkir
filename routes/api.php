<?php

use App\Http\Controllers\ParkirController;
use Illuminate\Support\Facades\Route;

Route::get('/parkir', [ParkirController::class, 'index']);
Route::post('/parkir', [ParkirController::class, 'store']);
Route::put('/parkir', [ParkirController::class, 'update']);
Route::delete('/parkir', [ParkirController::class, 'destroy']);
