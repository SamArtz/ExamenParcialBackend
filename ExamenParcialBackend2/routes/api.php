<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\LoanController;

Route::get('/books', [BookController::class, 'index']);
Route::post('/loans', [LoanController::class, 'store']);