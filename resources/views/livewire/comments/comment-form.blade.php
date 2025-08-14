<div class="bg-white rounded-xl border border-gray-100 p-6 mb-8">
    <h3 class="text-xl font-medium text-gray-800 mb-5">Leave a Comment</h3>

    @guest
        <p class="text-gray-600">
            Please <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-700 font-medium transition-colors">sign in</a> to join the discussion.
        </p>
    @else
        <form wire:submit.prevent="addComment" class="space-y-5">
            <div>
                <textarea
                    wire:model="content"
                    rows="4"
                    class="w-full px-4 py-3 text-gray-700 border border-gray-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                    placeholder="Share your thoughts..."></textarea>
                @error('content')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex justify-end">
                <button
                    type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-5 py-2.5 rounded-lg transition-colors shadow-sm"
                >
                    Post Comment
                </button>
            </div>
        </form>
    @endguest
</div>
