<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <h1 class="text-2xl font-semibold text-gray-800">Manage Posts</h1>
            <p class="text-sm text-gray-500 mt-1">Review and manage all blog posts</p>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Title
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Author
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Published
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($posts as $post)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
    <a href="{{ route('posts.show', $post->slug) }}" class="text-sm font-medium text-gray-900 hover:text-teal-600">
        {{ $post->title }}
    </a>
</td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">

                                <div class="flex-shrink-0 h-8 w-8 bg-gray-100 rounded-full flex items-center justify-center text-gray-500 text-sm font-medium">
                                    {{ strtoupper(substr($post->user->name, 0, 1)) }}
                                </div>
                                <div class="ml-3">
                                    <div class="text-sm text-gray-500">{{ $post->user->name }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-medium {{ $post->status === 'published' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ ucfirst($post->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $post->published_at ? $post->created_at->format('M j, Y') : 'Draft' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-4">
                              <a href="{{ route('posts.show', $post->slug) }}" class="text-blue-600 hover:text-blue-900">
        View
    </a>
                            <button
                                wire:click="toggleStatus({{ $post->id }})"
                                class="text-teal-600 hover:text-teal-900"
                            >
                                {{ $post->status === 'published' ? 'Unpublish' : 'Publish' }}
                            </button>
                            <button
                                wire:click="deletePost({{ $post->id }})"
                                class="text-red-600 hover:text-red-900"
                            >
                                Delete
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t border-gray-100">
            {{ $posts->links() }}
        </div>
    </div>
</div>
