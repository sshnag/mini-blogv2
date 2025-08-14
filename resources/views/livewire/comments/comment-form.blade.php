<div class="bg-white rounded-2xl border border-gray-100 p-6">
    <h3 class="text-lg font-semibold text-gray-900 mb-4">Leave a Comment</h3>

    @guest
        <div class="text-center py-6">
            <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
            </svg>
            <p class="text-gray-600 mb-3">Please sign in to join the discussion.</p>
            <a href="{{ route('login') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition-colors">
                Sign In
            </a>
        </div>
    @else
        <form wire:submit.prevent="addComment" class="space-y-4">
            <div>
                <textarea
                    wire:model="content"
                    rows="4"
                    class="w-full px-4 py-3 text-gray-700 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all resize-none"
                    placeholder="Share your thoughts..."></textarea>
                @error('content')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex justify-end">
                <button
                    type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-6 py-2.5 rounded-lg transition-colors shadow-sm"
                >
                    Post Comment
                </button>
            </div>
        </form>
    @endguest
</div>
