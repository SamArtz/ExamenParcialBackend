<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\ReturnController;

Route::get('/books', [BookController::class, 'index']);
Route::post('/loans', [LoanController::class, 'store']);
Route::post('/returns/{loan_id}', [ReturnController::class, 'store']);