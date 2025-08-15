@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <article class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        @if($post->featured_image)
            <div class="w-full h-96">
                <img src="{{ Storage::url($post->featured_image) }}" 
                     alt="{{ $post->title }}" 
                     class="w-full h-full object-cover">
            </div>
        @endif
        
        <div class="p-8">
            <header class="mb-8">
                <h1 class="text-4xl font-bold text-gray-900 mb-4">{{ $post->title }}</h1>
                
                <div class="flex items-center justify-between text-sm text-gray-500 border-b border-gray-100 pb-4">
                    <div class="flex items-center space-x-4">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/>
                            </svg>
                            {{ $post->user->name }}
                        </span>
                        <span>{{ $post->created_at->format('F j, Y') }}</span>
                        <span>{{ $post->created_at->diffForHumans() }}</span>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 6 4 4 6.5 4c1.54 0 3.04.99 3.57 2.36h.87C11.46 4.99 12.96 4 14.5 4 17 4 19 6 19 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                            </svg>
                            {{ $post->likes->count() }} likes
                        </span>
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                            {{ $post->approvedComments->count() }} comments
                        </span>
                    </div>
                </div>
            </header>
            
            <div class="prose prose-lg max-w-none text-gray-700 mb-8">
                {!! nl2br(e($post->content)) !!}
            </div>
            
            <!-- Like Button -->
            <div class="border-t border-gray-100 pt-6 mb-8">
                @auth
                    <livewire:posts.like-post :post="$post" />
                @else
                    <div class="text-center">
                        <a href="{{ route('login') }}" 
                           class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 6 4 4 6.5 4c1.54 0 3.04.99 3.57 2.36h.87C11.46 4.99 12.96 4 14.5 4 17 4 19 6 19 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                            </svg>
                            Login to Like
                        </a>
                    </div>
                @endauth
            </div>

            <!-- Post Actions (Edit/Delete) for Authors and Admins -->
            @auth
                @if(Auth::user()->hasAnyRole(['author', 'admin']) && (Auth::id() === $post->user_id || Auth::user()->hasRole('admin')))
                    <div class="border-t border-gray-100 pt-6 mb-8">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-gray-800">Post Management</h3>
                            <div class="flex space-x-3">
                                <a href="{{ route('posts.edit', $post->id) }}" 
                                   class="inline-flex items-center px-4 py-2 bg-amber-100 text-amber-800 font-medium rounded-lg hover:bg-amber-200 transition-colors">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    Edit Post
                                </a>
                                
                                <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="inline" 
                                      onsubmit="return confirm('Are you sure you want to delete this post? This action cannot be undone.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="inline-flex items-center px-4 py-2 bg-red-100 text-red-800 font-medium rounded-lg hover:bg-red-200 transition-colors">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                        Delete Post
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif
            @endauth
            
            <!-- Comments Section -->
            <div class="border-t border-gray-100 pt-8">
                <h3 class="text-2xl font-semibold text-gray-900 mb-6">Comments ({{ $post->approvedComments->count() }})</h3>
                
                @auth
                    <livewire:comments.comment-form :post="$post" />
                @else
                    <div class="bg-gray-50 rounded-lg p-6 text-center mb-6">
                        <p class="text-gray-600 mb-4">Please login to leave a comment.</p>
                        <a href="{{ route('login') }}" 
                           class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition-colors">
                            Login
                        </a>
                        <span class="mx-2 text-gray-400">or</span>
                        <a href="{{ route('register') }}" 
                           class="inline-flex items-center px-4 py-2 bg-gray-600 text-white font-medium rounded-lg hover:bg-gray-700 transition-colors">
                            Register
                        </a>
                    </div>
                @endauth
                
                <livewire:comments.comments-list :post="$post" />
            </div>
        </div>
    </article>
</div>
@endsection
