<?php

use App\Http\Controllers\Api\V2\BlogApiController;
use App\Http\Controllers\Api\V2\ContactApiController;
use App\Http\Controllers\Api\V2\NaturalResourceApiController;
use App\Http\Controllers\Api\V2\PartnerApiController;
use App\Http\Controllers\Api\V2\SpeciesApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v2')->group(function () {

    // Species routes
    Route::get('species/featured', [SpeciesApiController::class, 'featured']);
    Route::get('species/stats',    [SpeciesApiController::class, 'stats']);
    Route::get('species/map',      [SpeciesApiController::class, 'map']);
    Route::get('species/gallery',  [SpeciesApiController::class, 'gallery']);
    Route::get('species',          [SpeciesApiController::class, 'index']);
    Route::get('species/{slug}',   [SpeciesApiController::class, 'show']);

    // Blog routes
    Route::get('blog/latest',    [BlogApiController::class, 'latest']);
    Route::get('blog/popular',   [BlogApiController::class, 'popular']);
    Route::get('blog/categories',[BlogApiController::class, 'categories']);
    Route::get('blog',           [BlogApiController::class, 'index']);
    Route::get('blog/{slug}',    [BlogApiController::class, 'show'])->whereAlpha('slug');

    // Blog comments
    Route::get('blog/{postId}/comments',  [BlogApiController::class, 'comments'])->whereNumber('postId');
    Route::post('blog/{postId}/comments', [BlogApiController::class, 'storeComment'])->whereNumber('postId');

    // Natural resources routes
    Route::get('natural-resources/featured',   [NaturalResourceApiController::class, 'featured']);
    Route::get('natural-resources/latest',     [NaturalResourceApiController::class, 'latest']);
    Route::get('natural-resources/categories', [NaturalResourceApiController::class, 'categories']);
    Route::get('natural-resources',            [NaturalResourceApiController::class, 'index']);
    Route::get('natural-resources/{slug}',     [NaturalResourceApiController::class, 'show']);

    // Contact
    Route::post('contact', [ContactApiController::class, 'store']);

    // Partners
    Route::get('partners', [PartnerApiController::class, 'index']);
});
