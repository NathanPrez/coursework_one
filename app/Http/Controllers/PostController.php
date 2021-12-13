<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\UserProfile;
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
        /* Polymorphic relationship, needs to set what type of profile uploaded */
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
        /* 
            If they have uploaded a file 
            and if they chose the 'shot' from dropwdown - extra security
        */
        if ($request->hasFile('file') and $request->type == "shot") 
        {
            $request->validate([
                "image" => "mimes:jpeg,png,mp4,mov",
            ]);

            $request->file->store('user_content', 'public');

            $p->imagePath = $request->file->hashName();
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
    public function show(Post $post)
    {
        $user = auth()->user();

        if($user !== null) 
        {
            if ($user->UserProfile !== null) 
            {
                $userType = "UserProfile";
                $userId = $user->userProfile->id;
            } 
            else 
            {
                $userType = "AdminProfile";
                $userId = $user->adminProfile->id;
            }
            return view('posts.show', ['post' => $post, 'userId' => $userId, 'userType' => $userType]);
        }
        else {
            return view('posts.show', ['post' => $post]);
        }
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

    public function apiIndex(Post $post)
    {
        $postComments = Comment::with('commentable')->where('post_id', $post->id)->get();

        return $postComments;
    }

    public function apiStore(Request $request, Post $post)
    {
        $c = new Comment();
        $c->body = $request["body"];
        
        if ($request["userType"] == "UserProfile")
        {
            $c->commentable_type = "App\Models\UserProfile";
        }
        else 
        {
            $c->commentable_type = "App\Models\AdminProfile";
        }

        $c->commentable_id = $request["userId"];
        $c->post_id = $post->id;
        $c->save();

        $postComments = Comment::with('commentable')->where('post_id', $post->id)->get();

        return $postComments;
    }
}
