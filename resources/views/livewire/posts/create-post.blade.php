<div class="bg-white rounded-xl border border-gray-100 p-6 shadow-sm mb-8">
    <h2 class="text-lg font-semibold text-gray-800 mb-4">Create New Post</h2>

    <form wire:submit.prevent="create" class="space-y-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
            <input type="text" wire:model.defer="title" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent">
            @error('title') <span class="mt-1 text-sm text-red-600">{{ $message }}</span> @enderror
        </div>

        <div
            <label class="block text-sm font-medium text-gray-700 mb-1">Content</label>
            <textarea wire:model.defer="content" rows="4" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent"></textarea>
            @error('content') <span class="mt-1 text-sm text-red-600">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Featured Image</label>
            <input type="file" wire:model="featured_image" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-gray-50 file:text-gray-700 hover:file:bg-gray-100">
            @error('featured_image') <span class="mt-1 text-sm text-red-600">{{ $message }}</span> @enderror
        </div>

        <div class="flex justify-end pt-2">
            <button type="submit" class="px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white rounded-lg transition-colors">
                Create Post
            </button>
        </div>
    </form>
</div>
