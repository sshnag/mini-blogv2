<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PostController extends Controller
{

    /**
     * Summary of index
     * Post feed view and retriving from like and comment model relationship
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $posts = Post::published()
            ->with('user')
            ->withCount(['likes', 'approvedComments'])
            ->latest()
            ->paginate(12);

        return view('posts.index', compact('posts'));
    }


    /**
     * Summary of postslist
     * All Posts page display
     * @return \Illuminate\Contracts\View\View
     */
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
     * Summary of show
     * Post Details page
     * @param mixed $slug
     * @return \Illuminate\Contracts\View\View
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



        return view('posts.show', compact('post'));
    }

    /**
     * Summary of create
     * Post Create page
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function create()
    {
        //check if the user is logged in
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        //check if the user has either author or admin role

        if (!Auth::user()->hasAnyRole(['author', 'admin'])) {
            abort(403, 'You do not have permission to create posts. Only authors and admins can create posts.');
        }

        return view('posts.create');
    }

    /**
     * Summary of edit
     * Post Editing form page
     * @param string $id
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit(string $id)
    {
        //check if the user is logged in
        if (!Auth::check()) {
            return redirect()->route('login');
        }


        //finding postid
        $post = Post::findOrFail($id);

        //check roles if the user has admin role
        if (Auth::id() !== $post->user_id && !Auth::user()->hasRole('admin')) {
            abort(403, 'You can only edit your own posts unless you are an admin.');
        }

        if (!Auth::user()->hasAnyRole(['author', 'admin'])) {
            abort(403, 'You do not have permission to edit posts. Only authors and admins can edit posts.');
        }

        return view('posts.edit', compact('post'));
    }

    /**
     * Summary of update
     * Post Update
     * @param \Illuminate\Http\Request $request
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
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


        //post input validation
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
     * Summary of destro
     * Post deletion
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
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
