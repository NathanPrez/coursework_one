<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Validator;
use App\Models\Post;
use App\Models\Comment;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();
        return view('posts.index', ['posts' => $posts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            "type" => "required|max:5",
            "body" => "required|max:511"
        ]);

        $p = new Post;
        $p->type = $validatedData["type"];
        $p->body = $validatedData["body"];

        $user = auth()->user();
        if ($user->UserProfile !== null) 
        {
            $p->postable_id = $user->userProfile->id;
            $p->postable_type = "App\Models\UserProfile";
        } 
        else 
        {
            $p->postable_id = $user->adminProfile->id;
            $p->postable_type = "App\Models\AdminProfile";
        }

        if ($request->hasFile('file')) 
        {
            $request->validate([
                "image" => "mimes:jpeg,png,mp4,mov",
            ]);

            $request->file->store('user_content', 'public');

            $p->imagePath = $request->file->hashName();
        }
        else 
        {
            $p->imagePath = "No";
        }

        $p->save();
        return redirect()->route('posts.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::findOrFail($id);
        $comments = Comment::all();
        return view('posts.show', ['post' => $post], ['comments' => $comments]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
