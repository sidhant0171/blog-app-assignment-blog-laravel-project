<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class PostController extends Controller
{
    // API 1: List all posts with comments count
    public function index()
    {
        $posts = Post::with('user')
            ->withCount('comments')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($posts);
    }

    // API 2: Get posts of a particular user
    public function userPosts(User $user)
    {
        $posts = $user->posts()
                      ->withCount('comments')
                      ->orderBy('created_at', 'desc')
                      ->get();

        return response()->json($posts);
    }

    // API 3: Search posts by keyword
    public function search(Request $request)
    {
        $keyword = $request->query('keyword');

        if (!$keyword) {
            return response()->json(['error' => 'Please provide a keyword.'], 400);
        }

        $posts = Post::with('user')->withCount('comments')
            ->where('title', 'like', "%{$keyword}%")
            ->orWhere('content', 'like', "%{$keyword}%")
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($posts);
    }

    // API 4: Create a post (Protected route)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
        ]);

        $post = auth()->user()->posts()->create($validated);

        return response()->json(['message' => 'Post created successfully.', 'post' => $post], 201);
    }
}