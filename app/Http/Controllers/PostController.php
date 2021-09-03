<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('index', 'show');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // dd($_GET);
        if (isset($_GET["sort"])) {
            if ($_GET["sort"] == "rating") {
                return view('posts.index', ["posts" => Post::with("user")->orderBy("rating", "desc")->get()]);
            } else {
                return view('posts.index', ["posts" => Post::with("user")->orderBy("created_at", "desc")->get()]);
            }
        } else {
            return view('posts.index', ["posts" => Post::with("user")->get()]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create', ['post' => null]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'caption' => ['required', 'max:255'],
            'description' => ['required', 'max:255'],
            'image' => ['required'],
        ]);
        $post = new Post();
        $post->caption = $request["caption"];
        $post->description = $request["description"];
        $post->user_id = Auth::id();
        $post->image = Image::make($request->file('image'))->resize(500, null, function ($constraint) {
            $constraint->aspectRatio();
        })->encode('data-url');

        $post->save();
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
        return view('posts.create', ['post' => $post]);
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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
    }

    public function userPosts()
    {
        $posts = Auth::user()->posts;
        return view('posts.index', ["posts" => $posts]);
    }

    public function likePost(Post $post)
    {
        $post->rating = $post->rating + 1;
        $post->save();
        return redirect()->route('posts.index');
    }
}
