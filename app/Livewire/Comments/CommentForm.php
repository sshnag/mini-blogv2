<?php

namespace App\Livewire\Comments;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class CommentForm extends Component
{
    public Post $post;
    public string $content = '';

    protected $rules = [
        'content' => 'required|min:3|max:1000',
    ];

    public function mount(Post $post)
    {
        $this->post = $post;
    }

    public function addComment()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $this->validate();


        Comment::create([
            'post_id' => $this->post->id,
            'user_id' => Auth::id(),
            'content' => $this->content,
        ]);

        $this->content = '';
$this->dispatch('commentAdded');

    }


    public function render()
    {
        return view('livewire.comments.comment-form');
    }
}
