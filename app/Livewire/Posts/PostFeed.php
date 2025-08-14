<?php

namespace App\Livewire\Posts;

use App\Models\Post;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;

class PostFeed extends Component
{
    public $uploadProgress = 0;

    use WithFileUploads;

    public $title;
    public $content;
    public $featured_image;
    public $editingPostId = null;
    public $existingFeaturedImage = null;

    protected $listeners = [
        'commentAdded' => '$refresh',
    ];

    protected $rules = [
        'title' => 'required|string|max:255',
        'content' => 'required|string',
        'featured_image' => 'nullable|image|max:2048',
    ];

    // Open edit form modal or area by loading post data
    public function openEditModal($postId)
    {
        $post = Post::findOrFail($postId);

        if (!Auth::user()->can('update', $post)) {
            abort(403);
        }

        $this->editingPostId = $post->id;
        $this->title = $post->title;
        $this->content = $post->content;
        $this->existingFeaturedImage = $post->featured_image;
        $this->featured_image = null; // reset new upload
    }

    // Update the post after editing
   public function updatePost()
{
    $post = Post::findOrFail($this->editingPostId);

    if (!Auth::user()->can('update', $post)) {
        abort(403);
    }

    $this->validate();

    $path = $this->existingFeaturedImage;

    if ($this->featured_image) {
        $path = $this->featured_image->store('posts', 'public');
    }

    $post->update([
        'title' => $this->title,
        'slug' => Str::slug($this->title) . '-' . uniqid(),
        'content' => $this->content,
        'featured_image' => $path,
    ]);

    session()->flash('success', 'Post updated successfully!');

    $this->reset(['editingPostId', 'title', 'content', 'featured_image', 'existingFeaturedImage']);

}

public function closeModal()
{
    $this->reset(['editingPostId', 'title', 'content', 'featured_image', 'existingFeaturedImage']);
}


    // Delete a post with authorization check
    public function deletePost($postId)
    {
        $post = Post::findOrFail($postId);

        if (!Auth::user()->can('delete', $post)) {
            abort(403);
        }

        $post->delete();

        session()->flash('success', 'Post deleted successfully!');
        $this->dispatch('$refresh');
    }

    // Create new post
public function save()
{
    $this->validate();

    if (!Auth::check() || !Auth::user()->hasAnyRole(['author', 'admin'])) {
        abort(403, 'Unauthorized');
    }

    $path = null;
    if ($this->featured_image) {
        $path = $this->featured_image->store('posts', 'public');
    }

    Post::create([
        'title' => $this->title,
        'slug' => Str::slug($this->title) . '-' . uniqid(),
        'content' => $this->content,
        'featured_image' => $path,
        'user_id' => Auth::id(),
    ]);

    // Reset only necessary fields
    $this->title = '';
    $this->content = '';
    $this->featured_image = null;
    $this->uploadProgress = 0;
    $this->resetValidation();

    session()->flash('success', 'Post created successfully!');
}
public function updatedFeaturedImage()
{
    $this->uploadProgress = 0;
    $this->resetValidation();
}

    public function render()
    {
       $posts = Post::published()
    ->with('user')
    ->withCount('likes')
    ->where('published_at', '>=', now()->subWeek())
    ->orderByDesc('likes_count')
    ->take(3)
    ->get();


        return view('livewire.posts.post-feed', compact('posts'));
    }
}
