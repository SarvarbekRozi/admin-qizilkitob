<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\NaturalResourceController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\ProtectedAreaController;
use App\Http\Controllers\Admin\SiteStatController;
use App\Http\Controllers\Admin\SpeciesController;
use App\Http\Controllers\Admin\TeamMemberController;
use Illuminate\Support\Facades\Route;

// Root redirect
Route::get('/', fn() => redirect()->route('admin.dashboard'));

// Auth routes
Route::get('login', [AuthController::class, 'showLogin'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login.post');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// Admin routes (auth protected)
Route::prefix('admin')->middleware('auth')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Species
    Route::resource('species', SpeciesController::class);

    // Blog
    Route::get('blog', [BlogController::class, 'index'])->name('blog.index');
    Route::get('blog/create', [BlogController::class, 'create'])->name('blog.create');
    Route::post('blog', [BlogController::class, 'store'])->name('blog.store');
    Route::get('blog/{blog}/edit', [BlogController::class, 'edit'])->name('blog.edit');
    Route::put('blog/{blog}', [BlogController::class, 'update'])->name('blog.update');
    Route::delete('blog/{blog}', [BlogController::class, 'destroy'])->name('blog.destroy');

    // Blog categories
    Route::get('blog-categories', [BlogController::class, 'categoriesIndex'])->name('blog.categories.index');
    Route::post('blog-categories', [BlogController::class, 'categoryStore'])->name('blog.categories.store');
    Route::delete('blog-categories/{category}', [BlogController::class, 'categoryDestroy'])->name('blog.categories.destroy');

    // Natural Resources
    Route::resource('natural-resources', NaturalResourceController::class);

    // Contacts
    Route::get('contacts', [ContactController::class, 'index'])->name('contacts.index');
    Route::get('contacts/{contact}', [ContactController::class, 'show'])->name('contacts.show');
    Route::patch('contacts/{contact}/read', [ContactController::class, 'markAsRead'])->name('contacts.read');
    Route::delete('contacts/{contact}', [ContactController::class, 'destroy'])->name('contacts.destroy');

    // Partners
    Route::resource('partners', PartnerController::class);

    // Protected Areas
    Route::resource('protected-areas', ProtectedAreaController::class);

    // Site Stats
    Route::resource('site-stats', SiteStatController::class);

    // Team Members
    Route::resource('team', TeamMemberController::class);
});
