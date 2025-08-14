<div class="max-w-3xl mx-auto px-4 py-8 space-y-8">
    <!-- Flash message -->
    @if (session()->has('message'))
        <div class="p-4 bg-green-100 text-green-800 rounded-lg">
            {{ session('message') }}
        </div>
    @endif

    <!-- Create Post Form -->
    <form wire:submit.prevent="createPost" class="bg-white p-6 rounded-xl shadow space-y-4">
        <h2 class="text-xl font-bold">Create Post</h2>

        <input type="text" wire:model="title" placeholder="Post title"
               class="w-full border-gray-300 rounded-lg" />
        @error('title') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror

                          <textarea wire:model="content" placeholder="Post content"
                   class="w-full border-gray-300 rounded-lg"></textarea>
         @error('content') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror

         <div>
             <label class="block text-sm font-medium text-gray-700 mb-1">Featured Image</label>
             <input type="file" wire:model="featured_image" accept="image/*"
                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-gray-50 file:text-gray-700 hover:file:bg-gray-100" />
             @error('featured_image') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
         </div>

         <button type="submit"
                 class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
             Create
         </button>
    </form>

    <!-- Posts List -->
    <div class="space-y-4">
        @foreach ($posts as $post)
                         <div class="bg-white p-6 rounded-xl shadow">
                 @if($post->featured_image)
                     <img src="{{ Storage::url($post->featured_image) }}"
                          alt="{{ $post->title }}"
                          class="w-full h-48 object-cover rounded-lg mb-4">
                 @endif
                 <h3 class="text-lg font-bold">{{ $post->title }}</h3>
                 <p class="text-gray-700">{{ $post->content }}</p>
                 <p class="text-sm text-gray-500">By {{ $post->user->name }}</p>

                @if (auth()->id() === $post->user_id)
                                         <div class="mt-2 flex gap-2">
                         <button wire:click="edit({{ $post->id }})"
                                 class="bg-yellow-500 text-white px-3 py-1 rounded-lg">
                             Edit
                         </button>
                         <button wire:click="confirmDelete({{ $post->id }})"
                                 class="bg-red-600 text-white px-3 py-1 rounded-lg">
                             Delete
                         </button>
                     </div>
                @endif
            </div>
        @endforeach
    </div>

              <!-- Edit Modal -->
     @if($showEditModal)
         <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-[9999] p-4">
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

                 <h2 class="text-xl font-semibold text-gray-900 mb-6">Edit Post</h2>

                 <form wire:submit.prevent="update" class="space-y-6">
                     <div>
                         <label class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                         <input
                             type="text"
                             wire:model.defer="title"
                             class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all"
                             placeholder="Enter post title"
                         >
                         @error('title') <span class="mt-2 text-sm text-red-600">{{ $message }}</span> @enderror
                     </div>

                     <div>
                         <label class="block text-sm font-medium text-gray-700 mb-2">Content</label>
                         <textarea
                             wire:model.defer="content"
                             rows="6"
                             class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all resize-none"
                             placeholder="Write your post content..."
                         ></textarea>
                         @error('content') <span class="mt-2 text-sm text-red-600">{{ $message }}</span> @enderror
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
                         <input
                             type="file"
                             wire:model="featured_image"
                             accept="image/*"
                             class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-gray-50 file:text-gray-700 hover:file:bg-gray-100 transition-colors"
                         >
                         @error('featured_image') <span class="mt-2 text-sm text-red-600">{{ $message }}</span> @enderror
                     </div>

                     <div class="flex justify-end space-x-3 pt-6 border-t border-gray-100">
                         <button
                             type="button"
                             wire:click="$set('showEditModal', false)"
                             class="px-6 py-2.5 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors font-medium"
                         >
                             Cancel
                         </button>
                         <button
                             type="submit"
                             class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition-colors font-medium"
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
         <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-[9999] p-4">
             <div class="bg-white rounded-2xl shadow-xl max-w-md w-full p-6">
                 <div class="text-center">
                     <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                         <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                         </svg>
                     </div>
                     <h2 class="text-xl font-semibold text-gray-900 mb-2">Delete Post</h2>
                     <p class="text-gray-600 mb-6">Are you sure you want to delete this post? This action cannot be undone.</p>
                 </div>

                 <div class="flex justify-end space-x-3">
                     <button
                         type="button"
                         wire:click="$set('showDeleteModal', false)"
                         class="px-6 py-2.5 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors font-medium"
                     >
                         Cancel
                     </button>
                     <button
                         type="button"
                         wire:click="delete"
                         class="px-6 py-2.5 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors font-medium"
                     >
                         Delete Post
                     </button>
                 </div>
             </div>
         </div>
          @endif
 </div>
