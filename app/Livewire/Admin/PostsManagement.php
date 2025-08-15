<?php

namespace App\Livewire\Admin;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class PostsManagement extends Component
{
    use WithPagination;

    //for post stauts changing 'publish, draft'
    public function toggleStatus(Post $post) {
        $post->update([
            'status'=>$post->status =='published' ?'draft' : 'published',
            'published_at'=>$post->status=== 'draft' ? now() :null
        ]);
    }

    //for post deletion
    public function deletePost(Post $post){
        $post->delete();
    }
    public function render()
{
    //post andu user model relationshop and pagination
        $posts = Post::with('user')
            ->latest()
            ->paginate(10);

        return view('livewire.admin.posts-management', compact('posts'));
    }
}
