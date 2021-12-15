@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ URL::asset('css/user.css') }}">
@endsection

@section('content')
    <button onclick="location.href='{{ route('posts.index') }}'">Back</button>

    <div class="userbox">
        <div class="row">
            <!-- Profile Picture --> 
            <div class="col-md-4 mx-auto centre">
                <!-- Checking if admin/user and if they have a custom profile picture -->
                @if($user->userProfile == null)
                    <img src="../imgs/admin_profile_pic.jpg" alt="Admin Profile Picture">
                @else
                    @if($user->userProfile->profilePicturePath == "default_profile_pic.jpg")
                        <img src="../imgs/default_profile_pic.jpg" alt="User Profile Picture">
                    @else
                        <img src="{{ asset('storage/user_content/' . $user->userProfile->profilePicturePath) }}" alt="User Profile Picture">
                    @endif
                @endif
            </div>

            <!-- If they aren't logged in, following/unfollowing is not visible -->
            @guest
                <div class="col-md-8 my-auto">
                    @if($user->userProfile == null)
                        <h2>Admin {{ $user->adminProfile->id }}</h2>
                    @else
                        <h2>{{ $user->userProfile->username }}</h2>
                        <p>{{ $user->userProfile->bio }}</p>
                    @endif
                </div>
            @endguest
            
            @auth
                <div class="col-md-6 my-auto">
                    @if($user->userProfile == null)
                        <h2>Admin {{ $user->adminProfile->id }}</h2>
                    @else
                        <h2>{{ $user->userProfile->username }}</h2>
                        <p>{{ $user->userProfile->bio }}</p>
                    @endif
                </div>
                <!-- Checking whether the user is following this profile -->
                 <div class="col-md-2 my-auto">
                    @if($viewingUser !== null)
                        @if($viewingUser->follows->contains($user->userProfile->id))
                            <!-- If they are following then offer to unfollow -->
                            <form id="unfollow-form" method="post" action="{{ route('users.unfollow', ['user' => $user]) }}" enctype="multipart/form-data">
                                @csrf
                                @method('DELETE')
                                <button type="submit">Unfollow</button>
                            </form>
                        @elseif($viewingUser->id == $user->userProfile->id)
                        
                            
                        @else
                            <!-- If they aren't following then offer to follow -->
                            <form id="follow-form" method="post" action="{{ route('users.follow', ['user' => $user]) }}" enctype="multipart/form-data">
                                @csrf
                                <button type="submit">Follow</button>
                            </form>
                        @endif
                    @endif
                </div>
            @endauth
        </div>
    </div>

    @foreach($posts as $post)
        <div class="clickable">
            <div class="postbox {{$post->type}}" onclick="location.href='{{ route('posts.show', ['post'=>$post]) }}'">
                <div class="postbox__header">
                    <img src="{{ asset('storage/user_content/' . $post->postable->profilePicturePath) }}" alt="Profile Picture">
                    <a href="{{ route('users.show', ['user' => $post->postable->user->id]) }}">
                        <!-- Show username if user, otherwise, show 'Admin' + id -->
                        @if($post->postable->user->userProfile == null)
                            Admin {{$post->postable->user->adminProfile->id}}
                        @else
                            {{ $post->postable->user->userProfile->username }}
                        @endif
                    </a>
                </div>
                <div class="postbox__content">
                    <p>{{$post->body}}</p>
                    @if($post->type == "shot") 
                        <!-- Change html tag depending if it's video of img in database -->
                        @if( pathinfo(public_path($post->imagePath))['extension'] == "mp4" )
                            <video id="post-video" controls>
                                <source src="{{ asset('storage/user_content/' . $post->imagePath) }}">
                            </video>
                        @else
                            <img id="post-photo" src="{{ asset('storage/user_content/' . $post->imagePath) }}">
                        @endif
                    @endif
                </div>
            </div>
        </div>
    @endforeach
@endsection

