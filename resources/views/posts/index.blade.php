@extends('layouts.app')

@section('content')
    <!-- Loop through all posts -->
    <form id="posts-filter" method="get" action="{{ route('posts.index') }}">
        <div class="row">
            <div class="col-md-6 centre">
                Post Type:
                <select name="typeFilter" onchange="document.forms['posts-filter'].submit();">
                    @if(app('request')->input('typeFilter') == 'all' or app('request')->input('typeFilter') == null)
                        <option value="all" selected="selected">All</option>
                        <option value="shot">Shots</option>
                        <option value="meet">Meets</option>
                        <option value="chat">Chats</option>
                    @elseif(app('request')->input('typeFilter') == 'shot')
                        <option value="all">All</option>
                        <option value="shot" selected="selected">Shots</option>
                        <option value="meet">Meets</option>
                        <option value="chat">Chats</option>
                    @elseif(app('request')->input('typeFilter') == 'meet')
                        <option value="all">All</option>
                        <option value="shot">Shots</option>
                        <option value="meet" selected="selected">Meets</option>
                        <option value="chat">Chats</option>
                    @elseif(app('request')->input('typeFilter') == 'chat')
                        <option value="all">All</option>
                        <option value="shot">Shots</option>
                        <option value="meet">Meets</option>
                        <option value="chat" selected="selected">Chats</option>
                    @endif
                </select>
            </div>
            @auth
                <div class="col-md-6 centre">
                    @if(auth()->user()->userProfile !== null)
                        Creators:
                        <select name="creatorFilter" onchange="document.forms['posts-filter'].submit();">
                            @if(app('request')->input('creatorFilter') == 'all' or app('request')->input('creatorFilter') == null)
                                <option value="all" selected="selected">All</option>
                                <option value="follow">Following</option>
                            @else
                                <option value="all">All</option>
                                <option value="follow" selected="selected">Following</option>
                            @endif
                        </select>
                    @endif
                </div>
            @endauth

        </div>


    </form>

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
