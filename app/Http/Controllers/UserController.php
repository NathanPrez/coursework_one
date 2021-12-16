<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\AdminProfile;
use App\Models\Post;
use App\Models\Notification;


class UserController extends Controller
{

    //Show user's profile
    public function show(User $user)
    {
        /* 
            Check if the user is logged in 
            Needed for following/unfollowing
        */
        if (auth()->user() == null or auth()->user()->userProfile == null)
        {
            $viewingUser = null;
        }
        else 
        {
            $viewingUser = auth()->user()->userProfile;
        }

        if($user->userProfile == null)
        {
            $match = ['postable_id' => $user->adminProfile->id, 'postable_type' => 'App\Models\AdminProfile'];
            $posts = Post::where($match)->get();
        }
        else
        {
            $match = ['postable_id' => $user->userProfile->id, 'postable_type' => 'App\Models\UserProfile'];
            $posts = Post::where($match)->get();
        }

        return view('users.show', ['user' => $user, 'viewingUser' => $viewingUser, 'posts' => $posts]);
    }

    //create userprofile/adminprofile
    public function create()
    {
        return view('users.create');
    }


    //Store created user/admin profile
    public function store(Request $request)
    {        
        /* Creating and adding data to model */
        if ($request->type == "user")
        {
            //If a user, then must have a unique username
            $validatedData = $request->validate([
                "type" => "required|max:5",
                "username" => "required|unique:user_profiles|max:20|min:1",
                "bio" => "max:100",
            ]);

            $u = new UserProfile;
            $u->username = $validatedData["username"];
            $u->bio = $validatedData["bio"];
        }
        else 
        {
            $validatedData = $request->validate([
                "type" => "required|max:5",
            ]);

            $u = new AdminProfile;
        }

        $u->user_id = auth()->user()->id;

        /* If they have uploaded an image */
        if ($request->hasFile('file')) 
        {
            //Only allow png and jpeg for storage size, and security
            $request->validate([
                "image" => "mimes:jpeg,png",
            ]);

            $request->file->store('user_content', 'public');

            $u->profilePicturePath = $request->file->hashName();
        }

        $u->save();

        return redirect()->route('posts.index');
    }


    //reset session keys to logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
    
        $request->session()->regenerateToken();
    
        return redirect('/');
    }   


    //get logged in user and profile's user, then add to pivot table
    public function follow(User $user)
    {
        $viewingUser = auth()->user()->userProfile;
        $viewingUser->follows()->attach($user->userProfile->id);

        return redirect()->route("users.show", ['user' => $user]);
    }
    

    //get logged in user and profile's user, then remove from pivot table
    public function unfollow(User $user)
    {
        $viewingUser = auth()->user()->userProfile;
        $viewingUser->follows()->detach($user->userProfile->id);

        return redirect()->route("users.show", ['user' => $user]);
    } 


    //index of all notifications for a user
    public function getNotifications(User $user) 
    {
        //Get user/admin profile, and get all notifications attached to profile
        if($user->userProfile == null)
        {
            $match = ['notable_id' => $user->adminProfile->id, 'notable_type' => 'App\Models\AdminProfile'];
            $nots = Notification::where($match)->latest()->get();
        }
        else
        {
            $match = ['notable_id' => $user->userProfile->id, 'notable_type' => 'App\Models\userProfile'];
            $nots = Notification::where($match)->latest()->get();
        }

        return view("users.notifications", ['user' => $user, 'nots' => $nots]);
    }


    //delete selected notification
    public function deleteNotifications(Notification $not) {
        $not->delete();
        return redirect()->route("users.notifications", ['user' => auth()->user()]);
    }
}
