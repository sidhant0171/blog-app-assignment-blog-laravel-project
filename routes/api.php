<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\PostController; // Ensure this is the correct controller used below

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// === Routes required for Part 3 & Part 4 of your Assignment ===

// API Routes that require no authentication (Public)
// 1. List all posts with comments count
Route::get('/posts', [PostController::class, 'index']);
// 2. Search posts by keyword
Route::get('/posts/search', [PostController::class, 'search']);

// API Routes that require authentication (Protected)
Route::middleware('auth:sanctum')->group(function () {
    
    // 3. Route for creating a post
    Route::post('/posts', [PostController::class, 'store']);
    
    // 4. Route for submitting a comment (Used by show.blade.php AJAX)
    Route::post('/posts/{post}/comments', [CommentController::class, 'store']);
});

// === MISSING ROUTE (Public, but uses user ID) ===
// 5. Route to get posts of a particular user (outside the auth group if you allow public viewing of user posts)
// We will use {userId} as the parameter name for clarity with the controller function.
Route::get('/users/{userId}/posts', [PostController::class, 'userPosts']);