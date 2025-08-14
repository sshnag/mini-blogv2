<div class="max-w-4xl mx-auto px-4 py-8 space-y-8">
    {{-- Success message --}}
    @if(session()->has('message'))
        <div class="bg-green-50 text-green-600 p-4 rounded-lg">
            {{ session('message') }}
        </div>
    @endif
      {{-- Create Post Form --}}
    <div class="mb-8">
        <livewire:posts.create-post />
    </div>

    {{-- Posts Feed --}}
    <div class="space-y-8">
        @foreach($posts as $post)
        <article class="bg-white rounded-xl border border-gray-100 overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-200">
            @if($post->featured_image)
                <a href="{{ route('posts.show', $post->slug) }}" class="block aspect-video overflow-hidden">
                    <img
                        src="{{ Storage::url($post->featured_image) }}"
                        alt="{{ $post->title }}"
                        class="w-full h-full object-cover transition-transform duration-300 hover:scale-105"
                        loading="lazy"
                    >
                </a>
            @endif

            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center text-sm text-gray-500">
                        <span>{{ $post->user->name }}</span>
                        <span class="mx-2">•</span>
                       <time datetime="{{ $post->published_at?->toDateString() ?? now()->toDateString() }}">
    {{ $post->published_at?->format('M j, Y') ?? now()->format('M j, Y') }}
</time>

                    </div>
                    @can('update', $post)
                        <div class="flex space-x-2">
                            <button
                                wire:click="edit({{ $post->id }})"
                                class="text-blue-600 hover:text-blue-800 px-3 py-1 rounded-lg bg-blue-50 hover:bg-blue-100 transition-colors"
                            >
                                Edit
                            </button>
                            <button
                                wire:click="confirmDelete({{ $post->id }})"
                                class="text-red-600 hover:text-red-800 px-3 py-1 rounded-lg bg-red-50 hover:bg-red-100 transition-colors"
                            >
                                Delete
                            </button>
                        </div>
                    @endcan
                </div>

                <a href="{{ route('posts.show', $post->slug) }}" class="block">
                    <h2 class="text-xl font-bold text-gray-800 mb-3 hover:text-teal-600 transition-colors">
                        {{ $post->title }}
                    </h2>
                    <p class="text-gray-600 mb-4 line-clamp-3">
                        {{ Str::limit(strip_tags($post->content), 200) }}
                    </p>
                </a>

                <div class="flex items-center justify-between">
                    <a
                        href="{{ route('posts.show', $post->slug) }}"
                        class="inline-flex items-center text-teal-600 hover:text-teal-700 text-sm font-medium"
                    >
                        Read more
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                    <livewire:posts.like-post :post="$post" />
                </div>
            </div>
        </article>
        @endforeach
    </div>

    {{-- Edit Modal --}}
    @if($showEditModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
            <div class="bg-white rounded-xl shadow-lg max-w-2xl w-full p-6 relative max-h-[90vh] overflow-y-auto">
                <button
                    wire:click="$set('showEditModal', false)"
                    class="absolute top-4 right-4 text-gray-400 hover:text-gray-600"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <h2 class="text-xl font-semibold text-gray-800 mb-4">Edit Post</h2>

                <form wire:submit.prevent="update" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                        <input
                            type="text"
                            wire:model.defer="title"
                            class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent"
                        >
                        @error('title') <span class="mt-1 text-sm text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Content</label>
                        <textarea
                            wire:model.defer="content"
                            rows="6"
                            class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent"
                        ></textarea>
                        @error('content') <span class="mt-1 text-sm text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Featured Image</label>
                        @if($existingFeaturedImage)
                            <img
                                src="{{ Storage::url($existingFeaturedImage) }}"
                                class="w-full h-48 object-cover rounded-lg mb-2 border"
                            >
                        @endif
                        <input
                            type="file"
                            wire:model="featured_image"
                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-gray-50 file:text-gray-700 hover:file:bg-gray-100"
                        >
                        @error('featured_image') <span class="mt-1 text-sm text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex justify-end space-x-3 pt-4">
                        <button
                            type="button"
                            wire:click="$set('showEditModal', false)"
                            class="px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors"
                        >
                            Cancel
                        </button>
                        <button
                            type="submit"
                            class="px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white rounded-lg transition-colors"
                        >
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    {{-- Delete Modal --}}
    @if($showDeleteModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
            <div class="bg-white rounded-xl shadow-lg max-w-md w-full p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Delete Post</h2>
                <p class="text-gray-600 mb-6">Are you sure you want to delete this post? This action cannot be undone.</p>

                <div class="flex justify-end space-x-3">
                    <button
                        wire:click="$set('showDeleteModal', false)"
                        class="px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors"
                    >
                        Cancel
                    </button>
                    <button
                        wire:click="delete"
                        class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors"
                    >
                        Delete Post
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
