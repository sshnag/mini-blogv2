<?php
 namespace App\Livewire\Posts;

use App\Models\Post;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
 class PostShow extends Component
 {

    public Post $post;

    public function mount($slug)
    {
        $post = Post::published()
            ->where('slug', $slug)
            ->with(['user', 'likes', 'approvedComments.user', 'comments'])
            ->firstOrFail();

        $this->post = $post;
    }

    //lsitener for comment added
    protected $listeners = ['commentAdded' => 'refreshPost'];

    public function refreshPost()
    {

        $this->post = Post::published()
            ->where('slug', $this->post->slug)
            ->with(['-user', 'likes', 'approvedComments.user'])
            ->firstOrFail();
    }

    public function render(){
        return view('livewire.posts.post-show');
    }
 }
