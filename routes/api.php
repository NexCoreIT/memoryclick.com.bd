<?php

use App\Http\Controllers\Api\AboutApiController;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\BlogApiController;
use App\Http\Controllers\Api\CinematographyApiController;
use App\Http\Controllers\Api\ContactApiController;
use App\Http\Controllers\Api\CustomPageApiController;
use App\Http\Controllers\Api\HomeApiController;
use App\Http\Controllers\Api\PackageApiController;
use App\Http\Controllers\Api\PaymentApiController;
use App\Http\Controllers\Api\PhotographyApiController;
use App\Http\Controllers\Api\ServiceApiController;
use App\Http\Controllers\Api\SettingsApiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| API endpoints powering the Next.js frontend while keeping Laravel as
| the backend. All existing business logic, validation, and database
| interactions are preserved.
|
*/

// Site Settings & Global SEO
Route::get('/settings', [SettingsApiController::class, 'index']);

// Home Page Aggregated Data
Route::get('/home', [HomeApiController::class, 'index']);

// About Page & Team
Route::get('/about', [AboutApiController::class, 'index']);

// Services
Route::get('/services', [ServiceApiController::class, 'index']);
Route::get('/services/{slug}', [ServiceApiController::class, 'show']);

// Photography Portfolio & Details
Route::get('/photography', [PhotographyApiController::class, 'index']);
Route::get('/photography/{slug}', [PhotographyApiController::class, 'show']);

// Cinematography Portfolio
Route::get('/cinematography', [CinematographyApiController::class, 'index']);

// Packages & Divisions
Route::get('/packages/divisions', [PackageApiController::class, 'divisions']);
Route::get('/packages/division/{slug}', [PackageApiController::class, 'divisionPackages']);
Route::get('/packages/{id}', [PackageApiController::class, 'show']);

// Blogs & Articles
Route::get('/blogs', [BlogApiController::class, 'index']);
Route::get('/blogs/{slug}', [BlogApiController::class, 'show']);

// Custom / Legal Pages (e.g. Terms and Conditions)
Route::get('/page/{slug}', [CustomPageApiController::class, 'show']);

// Contact Form Submission
Route::post('/contact', [ContactApiController::class, 'store']);

// Checkout & Payment
Route::post('/checkout/pay', [PaymentApiController::class, 'initiate']);
Route::get('/order/{tran_id}', [PaymentApiController::class, 'getOrder']);

// Authentication Routes
Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthApiController::class, 'login']);
    Route::post('/register', [AuthApiController::class, 'register']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/me', [AuthApiController::class, 'me']);
        Route::post('/logout', [AuthApiController::class, 'logout']);
    });
});
