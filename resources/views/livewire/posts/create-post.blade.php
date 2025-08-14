<div class="max-w-3xl mx-auto p-6 bg-white shadow rounded">
    @if (session()->has('success'))
        <div class="mb-4 text-green-600">{{ session('success') }}</div>
    @endif

    <form wire:submit.prevent="save" class="space-y-6">

        <div>
            <label class="block mb-1 font-semibold">Title</label>
            <input type="text" wire:model="title" class="w-full border rounded p-2">
            @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block mb-1 font-semibold">Content</label>
            <textarea wire:model="content" rows="6" class="w-full border rounded p-2"></textarea>
            @error('content') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block mb-1 font-semibold">Featured Image</label>
            <input type="file" wire:model="featured_image" class="w-full">
            @error('featured_image') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

            @if ($featured_image)
                <div class="mt-2">
                    <img src="{{ $featured_image->temporaryUrl() }}" class="h-32 rounded">
                </div>
            @endif
        </div>

        <button type="submit"
            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Save Post
        </button>
    </form>
</div>
