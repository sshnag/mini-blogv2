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

    public function approveComment($commentId)
    {
        Comment::where('id', $commentId)->update(['is_approved' => true]);
    }

    public function disapproveComment($commentId)
    {
        Comment::where('id', $commentId)->update(['is_approved' => false]);
    }

    public function deleteComment($commentId)
    {
        Comment::where('id', $commentId)->delete();
    }

    public function render()
    {
        $comments = Comment::with(['user', 'post'])
            ->latest()
            ->paginate(15);

        return view('livewire.admin.comments-management', compact('comments'));
    }
}
