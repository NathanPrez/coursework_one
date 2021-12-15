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
    public function index(Request $request)
    {
        if($request->creatorFilter == null or $request->creatorFilter == "all")
        {
            $posts = Post::all();
        }
        else 
        {
            $ids = auth()->user()->userProfile->getFollowsId();
            $posts = Post::whereIn('id', $ids)->get();
        }
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
        //Pass logged in user details for ajax comments
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $validatedData = $request->validate([
            "body" => "required|max:511"
        ]);

        $p = $post;
        $p->body = $validatedData["body"];

        /* 
            If they have uploaded a file 
            and if they chose the 'shot' from dropwdown - extra security
        */
        if ($request->hasFile('file') and $p->type == "shot") 
        {
            $request->validate([
                "image" => "mimes:jpeg,png,mp4,mov",
            ]);

            $request->file->store('user_content', 'public');

            $p->imagePath = $request->file->hashName();
        }

        $p->save();

        return redirect()->route('posts.show', ["post" => $post]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('posts.index');
    }

}
