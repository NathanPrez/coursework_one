<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\UserProfile;
use App\Models\AdminProfile;


class UserController extends Controller
{
    public function index()
    {
        return view('users.index');
    }


    public function create()
    {
        $user = auth()->user();
        if ($user->userProfile == null and $user->adminProfile == null) 
        {
            return view('users.create');
        } 
        else 
        {
            return redirect()->route('posts.index');
        }
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            "type" => "required|max:5",
            "username" => "unique:user_profiles|max:20",
            "bio" => "max:100",
        ]);
        
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

        if ($request->hasFile('file')) 
        {
            $request->validate([
                "image" => "mimes:jpeg,png",
            ]);

            $request->file->store('user_content', 'public');

            $u->imagePath = $request->file->hashName();
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
}
