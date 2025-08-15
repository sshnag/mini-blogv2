<?php

namespace App\Livewire\Posts;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class EditPost extends Component
{
    use WithFileUploads;

    public Post $post;
    public $title;
    public $content;
    public $featured_image;
    public $existingFeaturedImage;

    //validation
    protected $rules = [
        'title' => 'required|string|max:255',
        'content' => 'required|string|min:10',
        'featured_image' => 'nullable|image|max:2048',
    ];

    public function mount(Post $post)
    {
        // Check if user has permission to edit this post
        if (!Auth::check() || !Auth::user()->hasAnyRole(['author', 'admin'])) {
            abort(403, 'You do not have permission to edit posts. Only authors and admins can edit posts.');
        }

        if (Auth::id() !== $post->user_id && !Auth::user()->hasRole('admin')) {
            abort(403, 'You can only edit your own posts unless you are an admin.');
        }

        $this->post = $post;
        $this->title = $post->title;
        $this->content = $post->content;
        $this->existingFeaturedImage = $post->featured_image;
    }

    public function update()
    {
        // check permission before updating
        if (!Auth::user()->hasAnyRole(['author', 'admin'])) {
            abort(403, 'You do not have permission to edit posts.');
        }

        if (Auth::id() !== $this->post->user_id && !Auth::user()->hasRole('admin')) {
            abort(403, 'You can only edit your own posts unless you are an admin.');
        }

        $this->validate();

        $data = [
            'title' => $this->title,
            'content' => $this->content,
            'slug' => Str::slug($this->title) . '-' . uniqid(),
        ];

        if ($this->featured_image) {
            $data['featured_image'] = $this->featured_image->store('posts', 'public');
        }

        //update data
        $this->post->update($data);

        session()->flash('message', 'Post updated successfully!');

        // redirect to the updated post
        return redirect()->route('posts.show', $this->post->slug);
    }

    public function render()
    {
        return view('livewire.posts.edit-post');
    }
}
