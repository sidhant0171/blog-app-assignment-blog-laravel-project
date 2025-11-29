<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * API/Route to list all posts with comments count.
     * GET /api/posts
     */
    public function index()
    {
        // Use withCount to efficiently get the number of comments for each post
        $posts = Post::with('user')
                     ->withCount('comments')
                     ->latest() // Order by latest post first
                     ->get();

        return response()->json($posts);
    }

    /**
     * API/Route to create a post (only for logged-in user).
     * POST /api/posts (Protected by auth:sanctum middleware)
     */
    public function store(Request $request)
    {
        // 1. Validation
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        // 2. Create the post using the authenticated user's relationship
        // Auth::user() is guaranteed to be available because the route is protected
        $post = Auth::user()->posts()->create($validatedData);

        // 3. Return success response
        return response()->json([
            'message' => 'Post created successfully', 
            'post' => $post
        ], 201); // 201 Created Status
    }

    /**
     * API/Route to search posts by keyword in title or content.
     * GET /api/posts/search?q=keyword
     */
    public function search(Request $request)
    {
        // Get the search keyword from the 'q' query parameter
        $keyword = $request->query('q');

        // Check if keyword is provided
        if (!$keyword) {
            return response()->json(['message' => 'Please provide a search keyword using the "q" parameter.'], 400);
        }

        // Use where and orWhere with LIKE to search in title and content
        $posts = Post::where('title', 'LIKE', "%{$keyword}%")
                     ->orWhere('content', 'LIKE', "%{$keyword}%")
                     ->with('user')
                     ->withCount('comments')
                     ->latest()
                     ->get();

        return response()->json([
            'message' => 'Search results for: ' . $keyword,
            'results' => $posts
        ]);
    }

    /**
     * API/Route to get posts of a particular user.
     * GET /api/users/{userId}/posts
     */
    public function userPosts($userId)
    {
        // Use the where clause to filter posts by user_id
        $posts = Post::where('user_id', $userId)
                     ->with('user')
                     ->withCount('comments')
                     ->latest()
                     ->get();

        // Check if posts were found
        if ($posts->isEmpty()) {
             return response()->json(['message' => 'No posts found for this user.'], 404);
        }

        return response()->json($posts);
    }
}