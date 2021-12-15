<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\AdminProfile;
use App\Models\Post;
use Illuminate\Support\Facades\Mail;



class UserController extends Controller
{
    public function show(User $user)
    {

        /* Check if the user is logged in */
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


    public function create()
    {
        return view('users.create');
    }


    public function store(Request $request)
    {        
        /* Creating and adding data to model */
        if ($validatedData["type"] == "user")
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
            $request->validate([
                "image" => "mimes:jpeg,png",
            ]);

            $request->file->store('user_content', 'public');

            $u->profilePicturePath = $request->file->hashName();
        }

        $u->save();

        return redirect()->route('posts.index');
    }


    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
    
        $request->session()->regenerateToken();
    
        return redirect('/');
    }   


    public function follow(User $user)
    {
        $viewingUser = auth()->user()->userProfile;
        $viewingUser->follows()->attach($user->userProfile->id);

        return redirect()->route("users.show", ['user' => $user]);
    }
    

    public function unfollow(User $user)
    {
        $viewingUser = auth()->user()->userProfile;
        $viewingUser->follows()->detach($user->userProfile->id);

        return redirect()->route("users.show", ['user' => $user]);
    } 
}
