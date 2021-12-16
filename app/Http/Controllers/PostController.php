<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\Post;
use App\Models\Comment;
use App\Services\Instagram;


class PostController extends Controller
{
 
    //Get all posts, with filters
    public function index(Request $request)
    {
        //All posts
        $posts = Post::latest()->simplePaginate(10);

        //Add filters if needed
        if($request->creatorFilter == "follow") 
        {
            //ids of who the user follows
            $ids = auth()->user()->userProfile->getFollowsId();

            //check if they have any extra filters
            if($request->typeFilter == "shot")
            {
                $posts = Post::whereIn('postable_id', $ids)->where('type', 'shot')->latest()->simplePaginate(10);
            }
            elseif($request->typeFilter == "chat")
            {
                $posts = Post::whereIn('postable_id', $ids)->where('type', 'chat')->latest()->simplePaginate(10);
            }
            elseif($request->typeFilter == "meet")
            {
                $posts = Post::whereIn('postable_id', $ids)->where('type', 'meet')->latest()->simplePaginate(10);
            }
            else 
            {
                $posts = Post::whereIn('postable_id', $ids)->latest()->simplePaginate(10);
            }
        }
        //If they choose all posts, or aren't logged in
        else 
        {
            //check if they have any filters
            if($request->typeFilter == "shot")
            {
                $posts = Post::where('type', 'shot')->latest()->simplePaginate(10);
            }
            elseif($request->typeFilter == "chat")
            {
                $posts = Post::where('type', 'chat')->latest()->simplePaginate(10);
            }
            elseif($request->typeFilter == "meet")
            {
                $posts = Post::where('type', 'meet')->latest()->simplePaginate(10);
            }
        }

        return view('posts.index', ['posts' => $posts]);
    }

    
    //return create view
    public function create()
    {
        return view('posts.create');
    }


    //store created post
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

    
    //Show specific post, with extra details
    public function show(Post $post)
    {
        $user = auth()->user();
        //If logged in, pass logged in user details for ajax comments
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
        //If user is not logged in
        else {
            return view('posts.show', ['post' => $post]);
        }
    }


    //Update post
    public function update(Request $request, Post $post)
    {
        $validatedData = $request->validate([
            "body" => "required|max:511"
        ]);

        $post->body = $validatedData["body"];

        /* 
            If they have uploaded a file 
        */
        if ($request->hasFile('file')) 
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


    //Delete Post
    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('posts.index');
    }


    //Service Container Fun
    public function postToInstagram(Instagram $indiegram, $text) {
        //Reference instagram and pass it data to 'post'
        echo $indiegram->post($text);
    }

}
