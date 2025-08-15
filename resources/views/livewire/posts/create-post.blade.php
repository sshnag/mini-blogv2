<div class="max-w-4xl mx-auto bg-white rounded-xl border border-gray-100 p-8 shadow-sm">
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-gray-900">Create New Post</h2>
        <p class="text-gray-600 mt-2">Share your thoughts with the community</p>
    </div>

    @if (session()->has('message'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-800 rounded-xl flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
            </svg>
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="create" class="space-y-6">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Post Title</label>
            <input type="text" 
                   wire:model.defer="title" 
                   placeholder="Enter a compelling title for your post"
                   class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
            @error('title') <span class="mt-2 text-sm text-red-600">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Post Content</label>
            <textarea wire:model.defer="content" 
                      rows="8" 
                      placeholder="Write your post content here..."
                      class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all resize-none"></textarea>
            @error('content') <span class="mt-2 text-sm text-red-600">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Featured Image (Optional)</label>
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
            @error('featured_image') <span class="mt-2 text-sm text-red-600">{{ $message }}</span> @enderror
        </div>

        <div class="flex justify-end pt-6 border-t border-gray-100">
            <button type="submit" 
                    class="px-8 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-xl transition-colors shadow-sm"
                    wire:loading.attr="disabled"
                    wire:target="create">
                <span wire:loading.remove wire:target="create">Create Post</span>
                <span wire:loading wire:target="create">Creating...</span>
            </button>
        </div>
    </form>
</div>
