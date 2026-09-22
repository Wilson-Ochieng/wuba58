<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\WorkController;
use App\Http\Controllers\ServicesController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/work', [WorkController::class, 'index'])->name('work.index');
Route::get('/work/{slug}', [WorkController::class, 'show'])->name('work.show');
Route::get('/services', [ServicesController::class, 'index'])->name('services');