<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\WorkController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ContactThreadController;
use App\Http\Controllers\ProcessController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\PhysicalModelsController;
use App\Http\Controllers\TourController;
use Illuminate\Support\Facades\Route;

// Static pages
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/services', [ServicesController::class, 'index'])->name('services');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/process', [ProcessController::class, 'index'])->name('process');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');

// Contact thread
Route::get('/message/{token}', [ContactThreadController::class, 'show'])->name('contact.thread');
Route::post('/message/{token}', [ContactThreadController::class, 'store'])->name('contact.thread.store');

// Work — specific routes MUST come before the dynamic /work/{slug}
Route::get('/work', [WorkController::class, 'index'])->name('work.index');
Route::get('/work/360-tour', [TourController::class, 'index'])->name('work.tour');
Route::get('/work/physical-models', [PhysicalModelsController::class, 'index'])->name('work.physical');
Route::get('/work/{slug}', [WorkController::class, 'show'])
    ->where('slug', '[a-z][a-z0-9-]*')   // extra safety: slug must start with a letter
    ->name('work.show');
Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
        'time' => now()->toIso8601String(),
    ]);
});