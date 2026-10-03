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
use App\Http\Controllers\FaqController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\BrochureController;
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
use App\Http\Controllers\BlogController;

Route::get('/journal', [BlogController::class, 'index'])->name('blog.index');
Route::get('/journal/{slug}', [BlogController::class, 'show'])->name('blog.show');

Route::get('/faq', [FaqController::class, 'index'])->name('faq');
Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::get('/privacy', [PageController::class, 'privacy'])->name('privacy');
Route::get('/e-brochure', [BrochureController::class, 'index'])->name('brochures.index');
Route::post('/e-brochure/request', [BrochureController::class, 'request'])->name('brochures.request');
Route::get('/e-brochure/{slug}', [BrochureController::class, 'show'])->name('brochures.show');
Route::get('/e-brochure/{slug}/thanks', [BrochureController::class, 'thanks'])->name('brochures.thanks');
