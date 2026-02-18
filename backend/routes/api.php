<?php

use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\FAQController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\NewsletterController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Authentication
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('simple.auth');

// Newsletter routes
Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe']);
Route::post('/newsletter/unsubscribe', [NewsletterController::class, 'unsubscribe']);
Route::post('/newsletter/subscribers', [NewsletterController::class, 'getSubscribers'])->middleware('simple.auth');

// User management routes (protected)
Route::middleware('simple.auth')->group(function () {
    Route::post('/users', [UserController::class, 'index']);
    Route::post('/users/create', [UserController::class, 'store']);
    Route::post('/users/{id}', [UserController::class, 'show']);
    Route::post('/users/{id}/update', [UserController::class, 'update']);
    Route::post('/users/{id}/delete', [UserController::class, 'destroy']);
});

// Articles - POST only for all operations
Route::post('/articles/recent', [ArticleController::class, 'recent']);
Route::post('/articles/{slug}/related', [ArticleController::class, 'related']);
Route::post('/articles', [ArticleController::class, 'index']);
Route::post('/articles/{slug}', [ArticleController::class, 'show']);
Route::post('/articles/create', [ArticleController::class, 'store'])->middleware('simple.auth');
Route::post('/articles/{slug}/update', [ArticleController::class, 'update'])->middleware('simple.auth');
Route::post('/articles/{slug}/delete', [ArticleController::class, 'destroy'])->middleware('simple.auth');

// Categories - POST only for all operations
Route::post('/categories', [CategoryController::class, 'index']);
Route::post('/categories/{slug}', [CategoryController::class, 'show']);
Route::post('/categories/create', [CategoryController::class, 'store']);
Route::post('/categories/{slug}/update', [CategoryController::class, 'update']);
Route::post('/categories/{slug}/delete', [CategoryController::class, 'destroy']);

// FAQ - POST only for all operations
Route::post('/faq', [FAQController::class, 'index']);
Route::post('/faq/create', [FAQController::class, 'store']);
Route::post('/faq/categories', [FAQController::class, 'categories']);
Route::post('/faq/{id}', [FAQController::class, 'show']);
Route::post('/faq/{id}/update', [FAQController::class, 'update']);
Route::post('/faq/{id}/delete', [FAQController::class, 'destroy']);
