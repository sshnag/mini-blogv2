<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\User;
use Livewire\WithFileUploads;

#[Layout('layouts.app')]
class UserProfile extends Component
{
    use WithFileUploads;

    public $name;
    public $email;
    public $avatar;
    public $existingAvatar;
    public $user;
    public $comments;   // user's comments
    public $likedPosts;

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
            'avatar' => 'nullable|image|max:2048',
        ];
    }

    public function mount()
    {
        $this->user = Auth::user();

        $this->comments = $this->user->comments()->with('post')->latest()->get();

        $this->likedPosts = $this->user->likedPosts()
            ->where('status', 'published')
            ->where('published_at', '<=', now())
            ->select('posts.id', 'posts.title', 'posts.slug', 'posts.created_at')
            ->latest()
            ->get();
            
        $this->name = $this->user->name;
        $this->email = $this->user->email;
        $this->existingAvatar = $this->user->avatar;
    }

    public function save()
    {
        $this->validate();

        $user = Auth::user();

        if ($this->avatar) {
            $avatarPath = $this->avatar->store('avatars', 'public');
            $user->avatar = $avatarPath;
            $this->existingAvatar = $avatarPath;
        }

        $user->name = $this->name;
        $user->email = $this->email;
        $user->save();

        session()->flash('success', 'Profile updated successfully.');

        //  refresh related data:
        $this->comments = $user->comments()->with('post')->latest()->get();
        $this->likedPosts = $user->likedPosts()
            ->where('status', 'published')
            ->where('published_at', '<=', now())
            ->select('posts.id', 'posts.title', 'posts.slug', 'posts.created_at')
            ->latest()
            ->get();
    }

    public function render()
    {
        return view('livewire.user-profile');
    }
}
