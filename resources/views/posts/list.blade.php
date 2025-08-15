@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">All Posts</h1>
            <p class="text-gray-600 mt-2">Browse through all published posts</p>
        </div>
        
        @auth
            @php
                $user = Auth::user();
                $hasAuthorRole = $user->hasRole('author');
                $hasAdminRole = $user->hasRole('admin');
                $canCreatePosts = $hasAuthorRole || $hasAdminRole;
            @endphp
            
            @if($canCreatePosts)
                <div class="mt-4 sm:mt-0">
                    <a href="{{ route('posts.create') }}" 
                       class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white font-medium rounded-xl hover:bg-indigo-700 transition-colors shadow-sm">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Create Post
                    </a>
                </div>
            @else
                <div class="mt-4 sm:mt-0">
                    <span class="inline-flex items-center px-6 py-3 bg-gray-300 text-gray-600 font-medium rounded-xl cursor-not-allowed">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Author Role Required
                    </span>
                    <!-- Debug info - remove in production -->
                    @if(config('app.debug'))
                        <div class="mt-2 text-xs text-gray-500">
                            Debug: User ID: {{ $user->id }}, 
                            Roles: {{ $user->roles->pluck('name')->implode(', ') }},
                            Has Author: {{ $hasAuthorRole ? 'Yes' : 'No' }},
                            Has Admin: {{ $hasAdminRole ? 'Yes' : 'No' }}
                        </div>
                    @endif
                </div>
            @endif
        @else
            <div class="mt-4 sm:mt-0">
                <a href="{{ route('login') }}" 
                   class="inline-flex items-center px-6 py-3 bg-gray-600 text-white font-medium rounded-xl hover:bg-gray-700 transition-colors shadow-sm">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                    </svg>
                    Login to Create Post
                </a>
            </div>
        @endauth
    </div>

    @if($posts->count() > 0)
        <div class="space-y-6">
            @foreach($posts as $post)
                <article class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
                    <div class="flex flex-col lg:flex-row gap-6">
                        @if($post->featured_image)
                            <div class="lg:w-1/3">
                                <a href="{{ route('posts.show', $post->slug) }}" class="block">
                                    <img src="{{ Storage::url($post->featured_image) }}" 
                                         alt="{{ $post->title }}" 
                                         class="w-full h-48 lg:h-32 object-cover rounded-lg">
                                </a>
                            </div>
                        @endif
                        
                        <div class="flex-1">
                            <h2 class="text-2xl font-semibold text-gray-900 mb-3">
                                <a href="{{ route('posts.show', $post->slug) }}" 
                                   class="hover:text-indigo-600 transition-colors">
                                    {{ $post->title }}
                                </a>
                            </h2>
                            
                            <p class="text-gray-600 mb-4 line-clamp-3">
                                {{ Str::limit($post->content, 200) }}
                            </p>
                            
                            <div class="flex items-center justify-between text-sm text-gray-500">
                                <div class="flex items-center space-x-4">
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/>
                                        </svg>
                                        {{ $post->user->name }}
                                    </span>
                                    <span>{{ $post->created_at->diffForHumans() }}</span>
                                </div>
                                
                                <div class="flex items-center space-x-3">
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 6 4 4 6.5 4c1.54 0 3.04.99 3.57 2.36h.87C11.46 4.99 12.96 4 14.5 4 17 4 19 6 19 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                        </svg>
                                        {{ $post->likes_count }}
                                    </span>
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                        </svg>
                                        {{ $post->approved_comments_count }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
        
        <div class="mt-8">
            {{ $posts->links() }}
        </div>
    @else
        <div class="text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">No posts yet</h3>
            <p class="mt-1 text-sm text-gray-500">Get started by creating the first post.</p>
        </div>
    @endif
</div>
@endsection
