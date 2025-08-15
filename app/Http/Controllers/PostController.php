<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PostController extends Controller
{
   /
    public function index()
    {
        $posts = Post::published()
            ->with('user')
            ->withCount(['likes', 'approvedComments'])
            ->latest()
            ->paginate(12);

        return view('posts.index', compact('posts'));
    }

    public function postslist()
    {
        $posts = Post::published()
            ->with('user')
            ->withCount(['likes', 'approvedComments'])
            ->latest()
            ->paginate(15);

        return view('posts.list', compact('posts'));
    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        $post = Post::published()
            ->where('slug', $slug)
            ->with([
                'user',
                'likes',
                'approvedComments.user',
                'comments'
            ])
            ->firstOrFail();

        // Increment view count if needed (optional)
        // $post->increment('views');

        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (!Auth::user()->hasAnyRole(['author', 'admin'])) {
            abort(403, 'You do not have permission to create posts. Only authors and admins can create posts.');
        }

        return view('posts.create');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $post = Post::findOrFail($id);

        if (Auth::id() !== $post->user_id && !Auth::user()->hasRole('admin')) {
            abort(403, 'You can only edit your own posts unless you are an admin.');
        }

        if (!Auth::user()->hasAnyRole(['author', 'admin'])) {
            abort(403, 'You do not have permission to edit posts. Only authors and admins can edit posts.');
        }

        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $post = Post::findOrFail($id);

        if (Auth::id() !== $post->user_id && !Auth::user()->hasRole('admin')) {
            abort(403, 'You can only edit your own posts unless you are an admin.');
        }

        if (!Auth::user()->hasAnyRole(['author', 'admin'])) {
            abort(403, 'You do not have permission to update posts. Only authors and admins can update posts.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $post->update([
            'title' => $request->title,
            'content' => $request->content,
        ]);

        return redirect()->route('posts.show', $post->slug);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $post = Post::findOrFail($id);

        if (Auth::id() !== $post->user_id && !Auth::user()->hasRole('admin')) {
            abort(403, 'You can only delete your own posts unless you are an admin.');
        }

        if (!Auth::user()->hasAnyRole(['author', 'admin'])) {
            abort(403, 'You do not have permission to delete posts. Only authors and admins can delete posts.');
        }

        $post->delete();

        return redirect()->route('posts.index');
    }
}
