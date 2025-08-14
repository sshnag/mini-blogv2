<?php

namespace App\Livewire\Posts;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;

class PostsList extends Component
{
    use WithFileUploads;

    public $posts;
    public $postId;
    public $title;
    public $content;
    public $featured_image;
    public $existingFeaturedImage;

    public $showEditModal = false;
    public $showDeleteModal = false;

    protected $listeners = ['postCreated' => 'loadPosts'];

    protected $rules = [
        'title' => 'required|string|max:255',
        'content' => 'required|string',
        'featured_image' => 'nullable|image|max:2048',
    ];

    public function mount()
    {
        $this->loadPosts();
    }

    public function loadPosts()
    {
        $this->posts = Post::latest()->with('user')->get();
    }

    public function createPost()
    {
        $this->validate();

        $data = [
            'title' => $this->title,
            'content' => $this->content,
            'user_id' => Auth::id(),
            'status' => 'published',
            'published_at' => now(),
        ];

        if ($this->featured_image) {
            $data['featured_image'] = $this->featured_image->store('posts', 'public');
        }

        $post = Post::create($data);

        $this->reset(['title', 'content', 'featured_image']);
        // Redirect to the public show route so it doesn't 404
        return redirect()->route('posts.show', $post->slug);
    }

    /** Open edit modal */
    public function edit($id)
    {
        $post = Post::findOrFail($id);
        $this->postId = $post->id;
        $this->title = $post->title;
        $this->content = $post->content;
            $this->existingFeaturedImage = $post->featured_image; // <-- add this

        $this->featured_image = null;
        $this->showEditModal = true;
    }

    /** Save post changes */
    public function update()
    {
        $this->validate();

        $post = Post::findOrFail($this->postId);

        $data = [
            'title' => $this->title,
            'content' => $this->content,
        ];

        if ($this->featured_image) {
            $data['featured_image'] = $this->featured_image->store('posts', 'public');
        }

        $post->update($data);

        $this->reset(['postId', 'title', 'content', 'featured_image']);
        $this->showEditModal = false;

        session()->flash('message', 'Post updated successfully!');
        $this->loadPosts();
    }

    /** Open delete confirmation */
    public function confirmDelete($id)
    {
        $this->postId = $id;
        $this->showDeleteModal = true;
    }

    /** Delete the post */
    public function delete()
    {
        Post::findOrFail($this->postId)->delete();
        $this->reset('postId');
        $this->showDeleteModal = false;

        session()->flash('message', 'Post deleted successfully!');
        $this->loadPosts();
    }

    public function render()
    {
        return view('livewire.posts.posts-list');
    }
}
