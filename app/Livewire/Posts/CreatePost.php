<?php

namespace App\Livewire\Posts;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CreatePost extends Component
{
    use WithFileUploads;

    public $title;
    public $content;
    public $featured_image;

    //validationn
    protected $rules = [
        'title' => 'required|string|max:255',
        'content' => 'required|string|min:10',
        'featured_image' => 'nullable|image|max:2048',
    ];

    public function mount()
    {
        // Check if user has permission to create posts
        if (!Auth::check() || !Auth::user()->hasAnyRole(['author', 'admin'])) {
            abort(403, 'You do not have permission to create posts. Only authors and admins can create posts.');
        }
    }

    /** Save new post */
    public function create()
    {
        // check permission before creating
        if (!Auth::user()->hasAnyRole(['author', 'admin'])) {
            abort(403, 'You do not have permission to create posts.');
        }

        $this->validate();

        $data = [
            'title' => $this->title,
            'content' => $this->content,
            'user_id' => Auth::id(),
            'status' => 'published',
            'published_at' => now(),
            'slug' => Str::slug($this->title) . '-' . uniqid(),
        ];

        //image data storing
        if ($this->featured_image) {
            $data['featured_image'] = $this->featured_image->store('posts', 'public');
        }

        //insert data
        $post = Post::create($data);

        $this->reset(['title', 'content', 'featured_image']);

        session()->flash('message', 'Post created successfully!');

        // Redirect to the created post
        return redirect()->route('posts.show', $post->slug);
    }

    public function render()
    {
        return view('livewire.posts.create-post');
    }
}
