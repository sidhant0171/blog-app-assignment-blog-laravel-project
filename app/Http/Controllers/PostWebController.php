<?php
namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostWebController extends Controller
{
    // Lists all posts for index.blade.php
    public function index()
    {
        $posts = Post::with('user')->withCount('comments')->orderBy('created_at', 'desc')->get();
        return view('posts.index', compact('posts'));
    }

    // Shows the create post form (create.blade.php)
    public function create()
    {
        // Check if user is logged in (optional, but good practice)
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        return view('posts.create');
    }

    // Stores the new post from the create form
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
        ]);

        auth()->user()->posts()->create($validated);

        return redirect()->route('posts.index')->with('success', 'Post created successfully!');
    }
    
    
    public function show(Post $post)
    {
        
        $post->load(['comments.user']);
        return view('posts.show', compact('post'));
    }
}