<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;


    public function user() 
    {
        return $this->belongsTo(User::class);
    }

    public function follows()
    {
        return $this->belongsToMany(UserProfile::class, 'user_profile_user_profile', 'user_profile_id', 'follows_id');
    }

    //Gets array of everyone the user is following
    public function getFollowsId() {
        return $this->follows->pluck('id');
    }

    public function followed()
    {
        return $this->belongsToMany(UserProfile::class, 'user_profile_user_profile', 'follows_id', 'user_profile_id');
    }
    
    public function posts() 
    {
        return $this->morphMany(Post::class, 'postable');
    }

    public function comments() 
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function notifications() 
    {
        return $this->morphMany(Notification::class, 'notable');
    }
}
