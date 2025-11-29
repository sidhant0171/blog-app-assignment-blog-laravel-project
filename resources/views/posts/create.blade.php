@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    {{-- Back Button added above the main heading --}}
<a href="{{ route('posts.index') }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-800 mb-4 transition duration-150">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor" style="width: 20px; height: 20px;">
        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
    </svg>
    Back to All Posts
</a>
    <h1 class="text-3xl font-bold mb-6 text-gray-800">Create a New Blog Post</h1>
    
    {{-- Form for submission. Action points to the 'posts.store' route --}}
    <form method="POST" action="{{ route('posts.store') }}" class="max-w-xl mx-auto bg-white shadow-xl rounded-lg p-8 border border-gray-200">
        @csrf {{-- Laravel's security token --}}

        {{-- Title Field --}}
        <div class="mb-5">
            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Post Title</label>
            <input 
                type="text" 
                class="w-full border border-gray-300 rounded-lg p-3 focus:ring-indigo-500 focus:border-indigo-500 @error('title') border-red-500 @enderror" 
                id="title" 
                name="title" 
                value="{{ old('title') }}" 
                required
            >
            @error('title')
                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
            @enderror
        </div>

        {{-- Content Field --}}
        <div class="mb-6">
            <label for="content" class="block text-sm font-medium text-gray-700 mb-2">Content</label>
            <textarea 
                class="w-full border border-gray-300 rounded-lg p-3 focus:ring-indigo-500 focus:border-indigo-500 @error('content') border-red-500 @enderror" 
                id="content" 
                name="content" 
                rows="10" 
                required
            >{{ old('content') }}</textarea>
            @error('content')
                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
            @enderror
        </div>

        {{-- Submit Button --}}
        <button 
            type="submit" 
            class="w-full bg-indigo-600 text-white font-semibold py-3 rounded-lg hover:bg-indigo-700 transition duration-300 shadow-md"
        >
            Publish Post
        </button>
    </form>
</div>
@endsection