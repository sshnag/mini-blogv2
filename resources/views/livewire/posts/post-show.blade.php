@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
    <article class="bg-white rounded-xl border border-gray-100 overflow-hidden shadow-sm">
        @if($post->featured_image)
            <div class="w-full aspect-video overflow-hidden">
                <img
                    src="{{ Storage::url($post->featured_image) }}"
                    alt="{{ $post->title }}"
                    class="w-full h-full object-cover transition-transform duration-500 hover:scale-105"
                    loading="lazy"
                >
            </div>
        @endif

        <div class="p-6 sm:p-8">
            <header class="mb-8">
                <div class="flex items-center text-sm text-gray-500 mb-3">
                    <span>{{ $post->created_at->format('F j, Y') }}</span>
                </div>

                <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 leading-tight mb-4">
                    {{ $post->title }}
                </h1>

                <div class="flex items-center">
                   @if($post->user->avatar)
    <img src="{{ Storage::url($post->user->avatar) }}" alt="{{ $post->user->name }}" class="h-10 w-10 rounded-full object-cover mr-3">
@else
    <div class="flex-shrink-0 h-10 w-10 bg-gray-100 rounded-full flex items-center justify-center text-gray-500 font-medium mr-3">
        {{ strtoupper(substr($post->user->name, 0, 1)) }}
    </div>
@endif

                    <span class="text-gray-700">{{ $post->user->name }}</span>
                </div>
            </header>

            <div class="prose prose-lg max-w-none text-gray-700 mb-10">
                {!! nl2br(e($post->content)) !!}
            </div>

            <livewire:posts.like-post :post="$post" />

            <section class="border-t border-gray-100 pt-8 mt-10">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-semibold text-gray-800">
    Comments ({{ $post->comments->count() }})
</h2>

                </div>

                <div class="space-y-6 mb-8">
                    <livewire:comments.comments-list :post="$post" />
                </div>

                <div class="bg-gray-50 rounded-xl p-6">
                    <livewire:comments.comment-form :post="$post" />
                </div>
            </section>
        </div>
    </article>
</div>
@endsection
