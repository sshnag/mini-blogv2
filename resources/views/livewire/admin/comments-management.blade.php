<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <h1 class="text-2xl font-semibold text-gray-800">Comment Management</h1>
            <p class="text-sm text-gray-500 mt-1">Review and moderate user comments</p>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Post
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            User
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Comment
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($comments as $comment)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ Str::limit($comment->post->title, 30) }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-8 w-8 bg-gray-100 rounded-full flex items-center justify-center text-gray-500 text-sm font-medium">
                                    {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                                </div>
                                <div class="ml-3">
                                    <div class="text-sm text-gray-500">{{ $comment->user->name }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-700">{{ Str::limit($comment->content, 50) }}</div>
                            <div class="text-xs text-gray-400 mt-1">
                                {{ $comment->created_at->diffForHumans() }}
                                @if($comment->is_approved)
                                    <span class="ml-2 px-1.5 py-0.5 rounded-full bg-green-100 text-green-800 text-xs">Approved</span>
                                @else
                                    <span class="ml-2 px-1.5 py-0.5 rounded-full bg-yellow-100 text-yellow-800 text-xs">Pending</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            @if($comment->is_approved)
                                <button
                                    wire:click="disapproveComment({{ $comment->id }})"
                                    class="text-yellow-600 hover:text-yellow-900 mr-4"
                                >
                                    Disapprove
                                </button>
                            @else
                                <button
                                    wire:click="approveComment({{ $comment->id }})"
                                    class="text-indigo-600 hover:text-indigo-900 mr-4"
                                >
                                    Approve
                                </button>
                            @endif
                            <button
                                wire:click="deleteComment({{ $comment->id }})"
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
            {{ $comments->links() }}
        </div>
    </div>
</div>
