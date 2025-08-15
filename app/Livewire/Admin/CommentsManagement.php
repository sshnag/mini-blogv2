<?php

namespace App\Livewire\Admin;

use App\Models\Comment;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class CommentsManagement extends Component
{
    use WithPagination;

    public $limit = null;

    public function mount($limit = null)
    {
        $this->limit = $limit;
    }

    public function approveComment($commentId)
    {
        try {
            $comment = Comment::findOrFail($commentId);
            $comment->update(['is_approved' => true]);
            session()->flash('message', 'Comment approved successfully.');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to approve comment.');
        }
    }

    public function disapproveComment($commentId)
    {
        try {
            $comment = Comment::findOrFail($commentId);
            $comment->update(['is_approved' => false]);
            session()->flash('message', 'Comment disapproved successfully.');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to disapprove comment.');
        }
    }

    public function deleteComment($commentId)
    {
        try {
            $comment = Comment::findOrFail($commentId);
            $comment->delete();
            session()->flash('message', 'Comment deleted successfully.');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to delete comment.');
        }
    }

    public function refresh()
    {
        $this->render();
    }

    public function render()
    {
        $query = Comment::with(['user', 'post'])->latest();
        
        if ($this->limit) {
            $comments = $query->take($this->limit)->get();
        } else {
            $comments = $query->paginate(15);
        }

        return view('livewire.admin.comments-management', compact('comments'));
    }
}
