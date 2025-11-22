<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ArticleController as AdminArticleController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\CommentController as AdminCommentController;
use App\Http\Controllers\Admin\ContactController as AdminContactController;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/article/{slug}', [ArticleController::class, 'show'])->name('article.show');
Route::post('/article/{slug}/comment', [ArticleController::class, 'addComment'])->name('article.comment');
Route::get('/category/{slug}', [CategoryController::class, 'show'])->name('category.show');
Route::get('/contact', [ContactController::class, 'show'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::resource('articles', AdminArticleController::class);
    Route::patch('/articles/{article}/toggle-status', [AdminArticleController::class, 'toggleStatus'])->name('articles.toggle-status');
    
    Route::resource('categories', AdminCategoryController::class);
    Route::resource('comments', AdminCommentController::class);
    Route::patch('/comments/{comment}/approve', [AdminCommentController::class, 'approve'])->name('comments.approve');
    Route::patch('/comments/{comment}/reject', [AdminCommentController::class, 'reject'])->name('comments.reject');
    Route::post('/comments/bulk-action', [AdminCommentController::class, 'bulkAction'])->name('comments.bulk-action');
    
    Route::resource('contacts', AdminContactController::class);
    Route::post('/contacts/bulk-action', [AdminContactController::class, 'bulkAction'])->name('contacts.bulk-action');
    Route::patch('/contacts/{contact}/mark-reviewed', [AdminContactController::class, 'markAsReviewed'])->name('contacts.mark-reviewed');
});
