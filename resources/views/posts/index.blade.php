@extends('layouts.app') 

@section('content')
<div class="container mx-auto p-4 max-w-4xl">
    
    {{-- Page Heading and Create Post Button --}}
    {{-- ADVANCED: Added border-b-4 for clear separation --}}
    <div class="flex justify-between items-center mb-10 border-b-4 border-teal-500 pb-4">
        {{-- ADVANCED: Large, bold heading --}}
        <h1 class="text-5xl font-extrabold text-gray-800 tracking-tight">Latest Blog Posts</h1>
        
        @auth
            {{-- ADVANCED: Teal color, strong shadow, and hover scale effect --}}
            <a href="{{ route('posts.create') }}" class="bg-teal-600 text-white px-6 py-3 rounded-xl text-lg font-semibold hover:bg-teal-700 transition duration-300 shadow-xl transform hover:scale-105">
                + Create New Post
            </a>
        @endauth
    </div>
    
    {{-- Success/Error Messages --}}
    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    {{-- Loop through all the posts --}}
    <div class="space-y-8">
        @forelse ($posts as $post)
            {{-- ADVANCED: Deep shadow, thick left border, and lift-up hover effect --}}
            <div class="bg-white shadow-2xl rounded-2xl p-8 border-l-8 border-blue-600 hover:shadow-3xl transition duration-500 ease-in-out transform hover:-translate-y-1">
                
                <h2 class="text-3xl font-bold text-gray-900 mb-3">{{ $post->title }}</h2> 
                
                <p class="text-sm text-gray-500 mb-4 border-b pb-3">
                    Author: <span class="font-semibold text-indigo-700 hover:text-indigo-900 transition duration-150">{{ $post->user->name }}</span> 
                    | 
                    Comments: <span class="font-semibold text-gray-700">{{ $post->comments_count }}</span>
                    |
                    Posted: {{ $post->created_at?->format('F d, Y') }}
                </p>
                
                {{-- ADVANCED: Larger text for content snippet --}}
                <p class="text-gray-700 leading-relaxed mb-4 text-lg">{{ Str::limit($post->content, 200, '...') }}</p>
                
                {{-- ADVANCED: Prominent Read More link with smooth arrow icon --}}
                <a href="{{ route('posts.show', $post) }}" class="text-lg font-bold text-blue-600 hover:text-blue-800 transition duration-200 inline-flex items-center group">
                    Read More & Comment 
                    <svg class="ml-1 w-4 h-4 transition duration-200 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>
            </div>
        @empty
            <div class="bg-yellow-50 border-l-4 border-yellow-500 text-yellow-700 p-6 rounded-lg shadow-lg" role="alert">
                <p class="font-bold text-xl">No Posts Found</p>
                <p>It looks like there are no blog posts yet. Be the first to create one!</p>
            </div>
        @endforelse
    </div>
</div>
@endsection