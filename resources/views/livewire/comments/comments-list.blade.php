<div class="space-y-6">
    @if($comments->isEmpty())
        <p class="text-gray-400 text-center py-6">Be the first to comment</p>
    @endif

    @foreach($comments as $comment)
        <div class="flex gap-4">
            <!-- Avatar -->
           <div class="flex-shrink-0">
    @if($comment->user->avatar)
        <img src="{{ Storage::url($comment->user->avatar) }}" alt="{{ $comment->user->name }}" class="h-10 w-10 rounded-full object-cover border border-gray-200">
    @else
        <div class="h-10 w-10 bg-gray-100 rounded-full flex items-center justify-center text-gray-500 font-medium border border-gray-200">
            {{ strtoupper(substr($comment->user->name, 0, 1)) }}
        </div>
    @endif
</div>


            <!-- Comment Content -->
            <div class="flex-1">
                <div class="bg-gray-50 rounded-xl p-4">
                    <div class="flex justify-between items-start">
                        <div>
                            <div class="flex items-center gap-2 mb-2">
                                <span class="font-medium text-gray-800">{{ $comment->user->name }}</span>
                                <span class="text-xs text-gray-400">•</span>
                                <span class="text-xs text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
                            </div>

                            @if($editingCommentId === $comment->id)
                                <textarea
                                    wire:model.defer="editContent"
                                    rows="3"
                                    class="w-full border rounded px-3 py-2"
                                ></textarea>
                                @error('editContent') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
                            @else
                                <p class="text-gray-700 whitespace-pre-line">{{ $comment->content }}</p>
                            @endif
                        </div>

                        @can('update', $comment)
                            @if($editingCommentId !== $comment->id)
                                <div class="ml-4 space-x-2">
                                    <button wire:click="openEditComment({{ $comment->id }})" class="text-blue-600 hover:underline text-sm">Edit</button>
                                    @can('delete', $comment)
                                        <button wire:click="deleteComment({{ $comment->id }})" class="text-red-600 hover:underline text-sm">Delete</button>
                                    @endcan
                                </div>
                            @endif
                        @endcan
                    </div>

                    @if($editingCommentId === $comment->id)
                        <div class="mt-2 space-x-2">
                            <button wire:click="updateComment" class="bg-indigo-600 text-white px-4 py-1 rounded hover:bg-indigo-700">
                                Save
                            </button>
                            <button wire:click="cancelEdit" class="bg-gray-300 px-4 py-1 rounded hover:bg-gray-400">
                                Cancel
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endforeach
</div>
