<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\AdminProfile;


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
        return view('users.show', ['user' => $user], ['viewingUser' => $viewingUser]);
    }


    public function create()
    {
        /*
        $user = auth()->user();
        if ($user->userProfile == null and $user->adminProfile == null) 
        {
            return view('users.create');
        } 
        else 
        {
            return redirect()->route('posts.index');
        }
        */
        return view('users.create');
    }


    public function store(Request $request)
    {
        /* Username must be unique */
        $validatedData = $request->validate([
            "type" => "required|max:5",
            "username" => "unique:user_profiles|max:20",
            "bio" => "max:100",
        ]);
        
        /* Creating and adding data to model */
        if ($validatedData["type"] == "user")
        {
            $u = new UserProfile;
            $u->username = $validatedData["username"];
            $u->bio = $validatedData["bio"];
        }
        else 
        {
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
        
        $viewingUser->follows()->attach($user->id);

        return redirect()->route("users.show", ['user' => $user]);
    }
    

    public function unfollow(User $user)
    {
        $viewingUser = auth()->user()->userProfile;

        $viewingUser->follows()->detach($user->id);

        return redirect()->route("users.show", ['user' => $user]);
    } 
}
