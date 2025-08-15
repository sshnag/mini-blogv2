<div class="max-w-2xl mx-auto bg-white rounded-xl border border-gray-100 shadow-sm p-6 sm:p-8">
    <div class="mb-8">
        <h1 class="text-2xl font-semibold text-gray-800">Profile Settings</h1>
        <p class="text-gray-500 mt-1">Update your personal information</p>
    </div>

    @if (session('success'))
        <div class="mb-6 p-3 bg-green-50 text-green-600 rounded-lg text-sm">
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit.prevent="save" class="space-y-6">
        <!-- Avatar Upload -->
        <div class="space-y-3">
            <label class="block text-sm font-medium text-gray-700">Profile Picture</label>
            <div class="flex items-center space-x-6">
                @if ($existingAvatar)
                    <img src="{{ asset('storage/' . $existingAvatar) }}"
                         class="h-16 w-16 rounded-full object-cover border-2 border-gray-200">
                @else
                    <div class="h-16 w-16 rounded-full bg-gray-100 flex items-center justify-center text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                @endif
                <div class="flex-1">
                    <input type="file"
                           wire:model="avatar"
                           class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-gray-50 file:text-gray-700 hover:file:bg-gray-100">
                    <p class="mt-1 text-xs text-gray-500">JPG, PNG or GIF (Max 2MB)</p>
                    @error('avatar') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <!-- Name -->
        <div class="space-y-2">
            <label class="block text-sm font-medium text-gray-700">Full Name</label>
            <input type="text"
                   wire:model="name"
                   class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
            @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <!-- Email -->
        <div class="space-y-2">
            <label class="block text-sm font-medium text-gray-700">Email Address</label>
            <input type="email"
                   wire:model="email"
                   class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
            @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <!-- Submit Button -->
        <div class="pt-4">
            <button type="submit"
                    class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg shadow-sm transition-colors">
                Save Changes
            </button>
        </div>
    </form>
    <section class="mb-8">
        <h3 class="text-lg font-semibold mb-2">Your Comments</h3>
        @if($comments->isEmpty())
            <p class="text-gray-500">You haven't made any comments yet.</p>
        @else
            <ul class="space-y-3">
                @foreach($comments as $comment)
                    <li class="border p-3 rounded">
                        <p>{{ $comment->content }}</p>
                        <p class="text-sm text-gray-500">
                            On post:
                            <a href="{{ route('posts.show', $comment->post->slug) }}" class="text-indigo-600 hover:underline">
                                {{ $comment->post->title }}
                            </a>
                            • {{ $comment->created_at->diffForHumans() }}
                        </p>
                    </li>
                @endforeach
            </ul>
        @endif
    </section>

    <!-- Liked Posts -->
    <section>
        <h3 class="text-lg font-semibold mb-2">Posts You've Liked</h3>
        @if($likedPosts->isEmpty())
            <p class="text-gray-500">You haven't liked any posts yet.</p>
        @else
            <ul class="space-y-3">
                @foreach($likedPosts as $post)
                    <li>
        <a href="{{ route('posts.show', $post->slug) }}" class="text-indigo-600 hover:underline font-medium">
                            {{ $post->title }}
                        </a>
                        <span class="text-sm text-gray-500"> • {{ $post->created_at->diffForHumans() }}</span>
                    </li>
                @endforeach
            </ul>
        @endif
    </section>

</div>
