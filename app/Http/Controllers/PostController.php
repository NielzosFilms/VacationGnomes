<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('posts.index', ["posts" => Post::with("User")->get()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::check()) {
            return view('posts.create', ['post' => null]);
        }
        return redirect()->route('posts.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Auth::check()) {
            $post = new Post();
            $post->caption = $request["caption"];
            $post->description = $request["description"];
            $post->user_id = Auth::id();
            $post->image = Image::make($request->file('image'))->resize(500, null, function ($constraint) {
                $constraint->aspectRatio();
            })->encode('data-url');

            $post->save();
        }
        return redirect()->route('posts.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('posts.show', ['post' => $post]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        if (Auth::check()) {
            return view('posts.create', ['post' => $post]);
        } else {
            return redirect()->route('posts.index');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        if (Auth::check()) {
        } else {
            return redirect()->route('posts.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        if (Auth::check()) {
        } else {
            return redirect()->route('index');
        }
    }

    public function userPosts()
    {
        if (Auth::check()) {
            $posts = Auth::user()->posts;
            return view('posts.index', ["posts" => $posts]);
        } else {
            return redirect()->route('index');
        }
    }
}
