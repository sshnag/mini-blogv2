<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('posts.index');
    }
    public function postslist()  {
        return view('posts.list');
    }

    /**
     * Show the form for creating a new resource.
     */

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
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
