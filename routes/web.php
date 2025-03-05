<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\JobController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\Admin\ArticleController;
use Illuminate\Support\Facades\Auth;

// Test Database Connection Route
Route::get('/test-db', function () {
    try {
        DB::connection()->getPdo();
        return 'Successfully connected to the database!';
    } catch (\Exception $e) {
        return 'Failed to connect to the database: ' . $e->getMessage();
    }
});

// Admin Authentication Routes
Route::get('/admin/login', [AuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'login']);
Route::get('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');

// Admin Routes with Prefix 'admin' and Middleware 'auth'
Route::prefix('admin')->middleware('auth')->group(function () {
    // Admin Dashboard Route
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    // Admin Job Management Routes
    Route::get('/jobs', [JobController::class, 'index'])->name('admin.jobs.index');
    Route::get('/jobs/create', [JobController::class, 'create'])->name('admin.jobs.create');
    Route::post('/jobs', [JobController::class, 'store'])->name('admin.jobs.store');
    Route::get('/jobs/{id}/edit', [JobController::class, 'edit'])->name('admin.jobs.edit');
    Route::put('/jobs/{id}', [JobController::class, 'update'])->name('admin.jobs.update');
    Route::delete('/jobs/{id}', [JobController::class, 'destroy'])->name('admin.jobs.destroy');
    Route::post('/jobs/{id}/mark-expired', [JobController::class, 'markExpired'])->name('admin.jobs.markExpired'); // **Moved to Admin routes**


    // Admin Article Management Routes
    Route::get('/articles', [ArticleController::class, 'index'])->name('admin.articles.index');  // Add this route
    Route::get('/articles/create', [ArticleController::class, 'create'])->name('admin.articles.create');
    Route::post('/articles', [ArticleController::class, 'store'])->name('admin.articles.store');
    Route::get('/articles/{id}/edit', [ArticleController::class, 'edit'])->name('admin.articles.edit');
    Route::put('/articles/{id}', [ArticleController::class, 'update'])->name('admin.articles.update');
    Route::delete('/articles/{id}', [ArticleController::class, 'destroy'])->name('admin.articles.destroy');
});

// Frontend Routes
Route::get('/', [HomeController::class, 'index'])->name('jobs.index');
Route::get('/jobs/load-more', [HomeController::class, 'loadMore'])->name('jobs.loadMore');
Route::get('/jobs/{id}', [HomeController::class, 'show'])->name('jobs.show');
Route::get('/search', [HomeController::class, 'search'])->name('jobs.search');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::post('/contact', [HomeController::class, 'submitContactForm'])->name('contact.submit');
Route::get('/government-jobs', [JobController::class, 'governmentJobs'])->name('government.jobs');
Route::post('/jobs/{id}/mark-expired', [JobController::class, 'markExpired'])->name('admin.jobs.markExpired');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/articles', [BlogController::class, 'index'])->name('articles.index');



// Blog Routes
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{id}', [BlogController::class, 'show'])->name('blog.show');
Route::get('/articles', [BlogController::class, 'index'])->name('articles.index'); // Changed route path to /articles (common for blog index) and route name to articles.index
Route::get('/articles/{id}', [BlogController::class, 'show'])->name('articles.show'); // Changed route path to /articles/{id} and route name to articles.show


// Auth Routes
Auth::routes();
