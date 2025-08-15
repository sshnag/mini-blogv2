<?php
namespace   App\Livewire\Posts;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class  LikePost extends Component{

    public Post $post;
    public bool $isLiked=false;
    public int $likesCount=0;

    public function mount(Post $post)  {
        $this->post=$post;
        $this->isLiked=$post->isLikedBy(Auth::user());
        $this->likesCount=$post->likes()->count();
    }

    //for like button
    public function toggleLike()
{
    //check if the user is logged in
    if (!Auth::check()) {
        return redirect()->route('login');
    }

    //increasing and decreasing the no of like
    if ($this->isLiked) {
        $this->post->likes()->where('user_id', Auth::id())->delete();
        $this->isLiked = false;
        $this->likesCount--;
    } else {
        $this->post->likes()->create([
            'user_id' => Auth::id(),
        ]);
        $this->isLiked = true;
        $this->likesCount++;
    }
}
         public function render()
    {
        return view('livewire.posts.like-post');
    }












}
