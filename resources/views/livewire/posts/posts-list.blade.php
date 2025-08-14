<div class="max-w-3xl mx-auto px-4 py-8 space-y-8">
    <!-- Flash message -->
    @if (session()->has('message'))
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
            </svg>
            {{ session('message') }}
        </div>
    @endif

    <!-- Create Post Form -->
    <form wire:submit.prevent="createPost" class="bg-white p-6 rounded-2xl shadow-md space-y-6 border border-gray-100">
        <h2 class="text-2xl font-bold text-gray-800">Create New Post</h2>

        <div class="space-y-2">
            <label class="text-sm font-medium text-gray-700">Post Title</label>
            <input type="text" wire:model="title" placeholder="Enter post title"
                   class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all" />
            @error('title') <span class="text-red-600 text-sm block mt-1">{{ $message }}</span> @enderror
        </div>

        <div class="space-y-2">
            <label class="text-sm font-medium text-gray-700">Post Content</label>
            <textarea wire:model="content" placeholder="Write your post content..."
                   class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all min-h-[120px]"></textarea>
            @error('content') <span class="text-red-600 text-sm block mt-1">{{ $message }}</span> @enderror
        </div>

        <div class="space-y-2">
            <label class="block text-sm font-medium text-gray-700">Featured Image</label>
            <div class="flex flex-col space-y-3">
                <label class="flex flex-col items-center justify-center w-full px-4 py-6 border-2 border-dashed border-gray-300 rounded-xl cursor-pointer hover:border-indigo-400 hover:bg-indigo-50 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span class="text-sm text-gray-600">Click to upload an image</span>
                    <input type="file" wire:model="featured_image" accept="image/*" class="hidden" />
                </label>
                <!-- Preview when selecting image -->
                <div class="w-full" x-data="{}">
                    <div wire:loading wire:target="featured_image" class="text-sm text-gray-500">Uploading image...</div>
                    @if ($featured_image)
                        <img src="{{ $featured_image->temporaryUrl() }}" alt="Preview" class="w-full h-48 object-cover rounded-xl border" />
                    @endif
                </div>
            </div>
            @error('featured_image') <span class="text-red-600 text-sm block mt-1">{{ $message }}</span> @enderror
        </div>

        <button type="submit"
                class="w-full bg-indigo-600 text-white px-6 py-3 rounded-xl hover:bg-indigo-700 transition-colors font-medium shadow-sm"
                wire:loading.attr="disabled"
                wire:target="createPost,featured_image">
            <span wire:loading.remove wire:target="createPost">Publish Post</span>
            <span wire:loading wire:target="createPost">Publishing...</span>
        </button>
    </form>

    <!-- Posts List -->
    <div class="space-y-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-2"> Posts</h2>

        @foreach ($posts as $post)
            <div class="bg-white p-6 rounded-2xl shadow-md border border-gray-100 hover:shadow-lg transition-shadow">
                @if($post->featured_image)
                    @if($post->status === 'published')
                        <a href="{{ route('posts.show', $post->slug) }}" class="block">
                            <img src="{{ Storage::url($post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-56 object-cover rounded-xl mb-4 border border-gray-200">
                        </a>
                    @else
                        <img src="{{ Storage::url($post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-56 object-cover rounded-xl mb-4 border border-gray-200">
                    @endif
                @endif
                <h3 class="text-xl font-bold text-gray-800">
                    @if($post->status === 'published')
                        <a href="{{ route('posts.show', $post->slug) }}" class="hover:text-indigo-600 transition-colors">{{ $post->title }}</a>
                    @else
                        {{ $post->title }}
                    @endif
                </h3>
                <p class="text-gray-600 mt-2">{{ $post->content }}</p>
                 <div class="flex items-center justify-between pt-2 border-t border-gray-100">
                            <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center mr-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <p class="text-sm text-gray-500">Posted by {{ $post->user->name }}</p>
                </div>
  <div class="flex items-center gap-4 text-xs text-gray-500">
                                <span class="inline-flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 6 4 4 6.5 4c1.54 0 3.04.99 3.57 2.36h.87C11.46 4.99 12.96 4 14.5 4 17 4 19 6 19 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                                    </svg>
                                    <span>{{ $post->likes_count }}</span>
                                </span>
                                <span class="inline-flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                    </svg>
                                    <span>{{ $post->approved_comments_count }}</span>
                                </span>
                            </div>
                 </div>
                @if($post->status === 'published')
                    <div class="mt-4">
                        <a href="{{ route('posts.show', $post->slug) }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-700 text-sm font-medium">
                            Read more
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                @endif

                @if (auth()->id() === $post->user_id)
                    <div class="mt-4 flex gap-3">
                        <button wire:click="edit({{ $post->id }})" class="flex items-center gap-1 bg-amber-100 text-amber-800 px-4 py-2 rounded-xl hover:bg-amber-200 transition-colors"> <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                    </svg>Edit</button>
                        <button wire:click="confirmDelete({{ $post->id }})" class="flex items-center gap-1 bg-red-100 text-red-800 px-3 py-1.5 rounded-lg hover:bg-red-200 transition-colors text-xs"> <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>Delete</button>
                    </div>
                @endif
            </div>
        @endforeach
    </div>

    <!-- Edit Modal -->
    @if($showEditModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-[9999] p-4 backdrop-blur-sm">
            <div class="bg-white rounded-2xl shadow-xl max-w-2xl w-full p-6 relative max-h-[90vh] overflow-y-auto">
                <button
                    wire:click="$set('showEditModal', false)"
                    class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 p-2 rounded-lg hover:bg-gray-100 transition-colors"
                    type="button"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <h2 class="text-2xl font-bold text-gray-800 mb-6">Edit Post</h2>

                <form wire:submit.prevent="update" class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                        <input
                            type="text"
                            wire:model.defer="title"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all"
                            placeholder="Enter post title"
                        >
                        {{-- @error('title') <span class="mt-2 text-sm text-red-600">{{ $message }}</span> @enderror --}}
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Content</label>
                        <textarea
                            wire:model.defer="content"
                            rows="6"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all resize-none"
                            placeholder="Write your post content..."
                        ></textarea>
                        {{-- @error('content') <span class="mt-2 text-sm text-red-600">{{ $message }}</span> @enderror --}}
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Featured Image</label>
                        @if($existingFeaturedImage)
                            <div class="mb-4">
                                <img
                                    src="{{ Storage::url($existingFeaturedImage) }}"
                                    class="w-full h-48 object-cover rounded-xl border border-gray-200"
                                    alt="Current featured image"
                                >
                            </div>
                        @endif
                        <div class="flex items-center space-x-4">
                            <label class="flex flex-col items-center justify-center w-full px-4 py-6 border-2 border-dashed border-gray-300 rounded-xl cursor-pointer hover:border-indigo-400 hover:bg-indigo-50 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span class="text-sm text-gray-600">Click to upload a new image</span>
                                <input type="file" wire:model="featured_image" accept="image/*" class="hidden" />
                            </label>
                        </div>
                        {{-- @error('featured_image') <span class="mt-2 text-sm text-red-600">{{ $message }}</span> @enderror --}}
                    </div>

                    <div class="flex justify-end space-x-3 pt-6 border-t border-gray-100">
                        <button
                            type="button"
                            wire:click="$set('showEditModal', false)"
                            class="px-6 py-2.5 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors font-medium"
                        >
                            Cancel
                        </button>
                        <button
                            type="submit"
                            class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl transition-colors font-medium"
                        >
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- Delete Modal -->
    @if($showDeleteModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-[9999] p-4 backdrop-blur-sm">
            <div class="bg-white rounded-2xl shadow-xl max-w-md w-full p-6">
                <div class="text-center">
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                        <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-gray-800 mb-2">Delete Post</h2>
                    <p class="text-gray-600 mb-6">Are you sure you want to delete this post? This action cannot be undone.</p>
                </div>

                <div class="flex justify-end space-x-3">
                    <button
                        type="button"
                        wire:click="$set('showDeleteModal', false)"
                        class="px-6 py-2.5 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors font-medium"
                    >
                        Cancel
                    </button>
                    <button
                        type="button"
                        wire:click="delete"
                        class="px-6 py-2.5 bg-red-600 hover:bg-red-700 text-white rounded-xl transition-colors font-medium"
                    >
                        Delete Post
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
