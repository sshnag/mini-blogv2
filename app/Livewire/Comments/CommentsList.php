<?php

namespace App\Livewire\Comments;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class CommentsList extends Component
{
    public Post $post;

    public $editingCommentId = null;
    public $editContent = '';

    protected $listeners = ['commentAdded' => '$refresh'];

    protected $rules = [
        'editContent' => 'required|min:3|max:1000',
    ];

    public function mount(Post $post)
    {
        $this->post = $post;
    }

    public function openEditComment($commentId)
    {
        $comment = Comment::findOrFail($commentId);

        if (Gate::denies('update', $comment)) {
            abort(403);
        }

        $this->editingCommentId = $comment->id;
        $this->editContent = $comment->content;
    }

    public function cancelEdit()
    {
        $this->editingCommentId = null;
        $this->editContent = '';
    }

    public function updateComment()
    {
        $this->validate();

        $comment = Comment::findOrFail($this->editingCommentId);

        if (Gate::denies('update', $comment)) {
            abort(403);
        }

        $comment->update(['content' => $this->editContent]);

        session()->flash('success', 'Comment updated successfully.');

        $this->editingCommentId = null;
        $this->editContent = '';

        $this->emit('$refresh');
    }

    public function deleteComment($commentId)
    {
        $comment = Comment::findOrFail($commentId);

        if (Gate::denies('delete', $comment)) {
            abort(403);
        }

        $comment->delete();

        session()->flash('success', 'Comment deleted successfully.');

        $this->emit('$refresh');
    }

    public function render()
    {
        return view('livewire.comments.comments-list', [
            'comments' => $this->post->approvedComments()->with('user')->latest()->get(),
        ]);
    }
}
