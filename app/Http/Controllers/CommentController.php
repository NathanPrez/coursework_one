<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\Post;
use App\Models\Comment;

class CommentController extends Controller
{
        //Get comments
        public function apiIndex(Post $post)
        {
            $postComments = Comment::with('commentable')->where('post_id', $post->id)->get();
    
            return $postComments;
        }
    
        public function apiStore(Request $request, Post $post)
        {
            $validatedData = $request->validate([
                "body" => "required|max:200",
                "userId" => "required|integer",
                "userType" => "required|max:12",
            ]);
    
            $c = new Comment();
            $c->body = $validatedData["body"];
    
            if ($validatedData["userType"] == "UserProfile")
            {
                $c->commentable_type = "App\Models\UserProfile";
            }
            else 
            {
                $c->commentable_type = "App\Models\AdminProfile";
            }
    
            $c->commentable_id = $validatedData["userId"];
            $c->post_id = $post->id;
            $c->save();
    
            $postComments = Comment::with('commentable')->where('post_id', $post->id)->get();
    
            return $postComments;
        }

        public function update(Request $request, Post $post)
        {
            $validatedData = $request->validate([
                "body" => "required|max:200",
                "commentId" => "required|integer",
            ]);
    
            $c = Comment::find($validatedData['commentId']);
            $c->body = $validatedData["body"];
            $c->save();
    
            return redirect()->route('posts.show', ["post" => $post]);
        }
}
