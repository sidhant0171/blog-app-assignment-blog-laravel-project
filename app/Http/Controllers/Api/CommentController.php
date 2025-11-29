<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    // API to store a new comment on a specific post
    public function store(Request $request, Post $post)
    {
        // Must be logged in (handled by route middleware)
        $validated = $request->validate(['comment' => 'required|string']);
        
        $comment = $post->comments()->create([
            'user_id' => auth()->id(), 
            'comment' => $validated['comment'],
        ]);

        return response()->json(['comment' => $comment->load('user')], 201);
    }
}