<?php

namespace App\Livewire\Admin;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class Dashboard extends Component
{
    public function render()
    {
        $stats=[
            'total_posts'=>Post::count(),
            'published_posts'=>Post::published()->count(),
            'pending_comments'=>Comment::where('is_approved',false)->count(),
            'total_users'=>User::count()
        ];
        $recentPosts=Post::with('user')->latest()->take(5)->get();
        
        return view('livewire.admin.dashboard', compact('stats', 'recentPosts'));
    }
}
