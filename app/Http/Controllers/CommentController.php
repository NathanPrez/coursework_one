<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Notification;

class CommentController extends Controller
{
        //Get all comments related to the given post
        public function apiIndex(Post $post)
        {
            $postComments = Comment::with('commentable')->where('post_id', $post->id)->get();
            return $postComments;
        }
    
        //Store comments realtime
        public function apiStore(Request $request, Post $post)
        {
            //passed user details through the request 
            $validatedData = $request->validate([
                "body" => "required|max:200",
                "userId" => "required|integer",
                "userType" => "required|max:12",
            ]);

            //Comment notification
            $allComments = $post->comments;
            $allUsers = [];
            //get everyone who's interacted with the post
            foreach($allComments as $comment) 
            {
                if (!in_array($comment->commentable, $allUsers))
                {
                    array_push($allUsers, $comment->commentable);

                }
            }

            //create a notification for each user
            foreach($allUsers as $user)
            {
                //No notification to the comment creator
                if($user->id !== $validatedData["userId"]) {
                    $n = new Notification;
                    //if user give their username, if admin give 'Admin' id
                    if ($validatedData["userType"] == "UserProfile")
                    {
                        $userpof = UserProfile::find($validatedData["userId"]);
                        $n->notification = $userpof->username." has commented on a post you have interacted with.";
                    }
                    else 
                    {
                        $n->notification = "Admin ".$validatedData["userId"]." has commented on a post you have interacted with.";
                    }                
                    
                    //Link to user
                    $n->notable_id = $user->id;
                    if ($user->UserProfile !== null) 
                    {
                        $n->notable_type = "App\Models\AdminProfile";
                    } 
                    else 
                    {
                        $n->notable_type = "App\Models\UserProfile";
                    }

                    $n->post_id = $post->id;
                    $n->save();
                }
            }

            //Create notification for post's owner
            if($post->postable->id !== $validatedData["userId"]) {
                $n = new Notification;
            
                if ($validatedData["userType"] == "UserProfile")
                {
                    $userprof = UserProfile::find($validatedData["userId"]);
                    $n->notification = $userprof->username." has commented on your post.";
                }
                else 
                {
                    $n->notification = "Admin ".$validatedData["userId"]." has commented on your post.";
                }
    
                $n->notable_id = $post->postable->id;
                if ($post->postable !== null) 
                {
                    $n->notable_type = "App\Models\UserProfile";
                } 
                else 
                {
                    $n->notable_type = "App\Models\AdminProfile";
                }
                $n->post_id = $post->id;
                $n->save();
            }

            //create comment
            $c = new Comment();
            $c->body = $validatedData["body"];
    
            //Link to user
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

            //Get all comments, including one just created
            $postComments = Comment::with('commentable')->where('post_id', $post->id)->get();
    
            return $postComments;
        }

        //Update comment, not realtime
        public function update(Request $request, Post $post)
        {
            //Like apiStore, got userId through request
            $validatedData = $request->validate([
                "body" => "required|max:200",
                "commentId" => "required|integer",
            ]);
    
            $c = Comment::find($validatedData['commentId']);
            $c->body = $validatedData["body"];
            $c->save();
    
            return redirect()->route('posts.show', ["post" => $post]);
        }

        //Delete comment, not realtime
        public function destroy(Request $request, Post $post) {
            Comment::find($request->commentId)->delete();
            return redirect()->route('posts.show', ["post" => $post]);
        }
}
