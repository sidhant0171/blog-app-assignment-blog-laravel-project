@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 max-w-4xl">

    {{-- 🔙 ADDED: Back to All Posts Button --}}
    <a href="{{ route('posts.index') }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-800 mb-6 transition duration-150 font-semibold group">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 transition duration-200 group-hover:-translate-x-0.5" viewBox="0 0 20 20" fill="currentColor" style="width: 20px; height: 20px;">
            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
        </svg>
        Back to All Posts
    </a>
    
    {{-- Post Content Section --}}
    {{-- STYLING ENHANCEMENT: Increased shadow and rounded corners --}}
    <div class="bg-white shadow-xl rounded-2xl p-10 mb-8 border-l-4 border-indigo-600">
        <h1 class="text-4xl font-extrabold mb-3 text-gray-900">{{ $post->title }}</h1>
        <p class="text-md text-gray-500 mb-6 border-b pb-4">
          Posted by: <strong class="text-indigo-600">{{ $post->user->name }}</strong> on {{ $post->created_at?->format('F d, Y') }}
        </p>
        
        <div class="text-gray-700 leading-relaxed text-lg">
            <p>{{ $post->content }}</p>
        </div>
    </div>

    {{-- Comments Section --}}
    <h3 class="text-2xl font-bold mb-4 text-gray-800">Comments ({{ $post->comments->count() }})</h3>
    
    {{-- AJAX Comment Form --}}
    @auth
        {{-- STYLING ENHANCEMENT: Added deep shadow --}}
        <div class="mb-8 bg-white p-6 rounded-lg shadow-xl border border-gray-200">
            <h4 class="text-xl font-semibold mb-4">Add Your Comment</h4>
            
            <form id="comment-form">
                @csrf
                <div class="mb-4">
                    <textarea 
                        class="w-full border border-gray-300 rounded-lg p-3 focus:ring-green-500 focus:border-green-500" 
                        id="comment-input" 
                        name="comment" 
                        rows="4" 
                        placeholder="Write your comment here..." 
                        required
                    ></textarea>
                    <div id="comment-error" class="text-red-500 text-sm mt-2" style="display:none;"></div>
                </div>
                <button type="submit" class="bg-green-600 text-white px-5 py-2 rounded-lg font-semibold hover:bg-green-700 transition duration-300 shadow-md">
                    Submit Comment (AJAX)
                </button>
            </form>
        </div>
    @else
        <p class="text-lg bg-yellow-100 border border-yellow-400 p-4 rounded-lg">
            Please <a href="{{ route('login') }}" class="text-blue-600 font-semibold hover:underline">log in</a> to post a comment.
        </p>
    @endauth

    {{-- List of Existing Comments --}}
    <div id="comments-list" class="space-y-4">
        @forelse ($post->comments->reverse() as $comment) {{-- Display latest comments first --}}
            {{-- STYLING ENHANCEMENT: Used white background for better contrast --}}
            <div class="bg-white p-4 rounded-lg shadow-md border-l-4 border-gray-200">
                <strong class="text-indigo-700">{{ $comment->user->name }}</strong> 
<span class="text-gray-500 text-sm">| {{ $comment->created_at?->diffForHumans() }}</span>:                <p class="text-gray-800 mt-1">{{ $comment->comment }}</p>
            </div>
        @empty
            <p class="text-gray-600">No comments yet. Be the first to comment!</p>
        @endforelse
    </div>

</div>

{{-- JAVASCRIPT FOR AJAX SUBMISSION (Part of the Assignment) --}}
@auth
<script>
    document.getElementById('comment-form').addEventListener('submit', function(e) {
        e.preventDefault(); 
        
        let commentInput = document.getElementById('comment-input');
        let commentText = commentInput.value;
        let errorDiv = document.getElementById('comment-error');
        errorDiv.style.display = 'none';

        // 1. Fetch Request to the API endpoint
        fetch('/api/posts/{{ $post->id }}/comments', { 
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                // Important: Get the CSRF token for security
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 
                'Accept': 'application/json',
            },
            body: JSON.stringify({ comment: commentText })
        })
        .then(response => {
            if (!response.ok) {
                // Handle server validation errors or other HTTP errors
                return response.json().then(data => { throw data; });
            }
            return response.json();
        })
        .then(data => {
            // 2. Success: Dynamically append the new comment
            let commentsList = document.getElementById('comments-list');
            let newCommentDiv = document.createElement('div');
            newCommentDiv.className = 'bg-green-100 p-4 rounded-lg shadow-sm border border-green-200 transition duration-500';
            
            // Note: Auth::user() is available here since the user is logged in
            let userName = "{{ optional(Auth::user())->name }}"; 

            newCommentDiv.innerHTML = `
                <strong class="text-green-700">${userName}</strong> 
                <span class="text-gray-500 text-sm">| Just now</span>:
                <p class="text-gray-800 mt-1">${data.comment.comment}</p>
            `;

            commentsList.prepend(newCommentDiv); // Add to the top of the list
            commentInput.value = ''; // Clear the input field
        })
        .catch(error => {
            // 3. Error Handling
            console.error('AJAX Error:', error);
            errorDiv.textContent = (error.errors && error.errors.comment) ? error.errors.comment[0] : 'Failed to post comment. Please try again.';
            errorDiv.style.display = 'block';
        });
    });
</script>
@endauth
@endsection