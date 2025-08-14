<?php

namespace App\Livewire\Posts;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;

class CreatePost extends Component
{
    use WithFileUploads;

    public $title;
    public $content;
    public $featured_image;

    protected $rules = [
        'title' => 'required|string|max:255',
        'content' => 'required|string',
        'featured_image' => 'nullable|image|max:2048',
    ];

    /** Save new post */
    public function create()
    {
        $this->validate();

        $data = [
            'title' => $this->title,
            'content' => $this->content,
            'user_id' => Auth::id(),
                'published_at' => now(),

        ];

        if ($this->featured_image) {
            $data['featured_image'] = $this->featured_image->store('posts', 'public');
        }

        Post::create($data);

        $this->reset(['title', 'content', 'featured_image']);

        session()->flash('message', 'Post created successfully!');

        $this->dispatch('postCreated');
    }

    public function render()
    {
        return view('livewire.posts.create-post');
    }
}
