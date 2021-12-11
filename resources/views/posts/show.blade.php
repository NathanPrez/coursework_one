@extends('layouts.app')

@section('content')
    <button class="back" onclick="location.href='{{ route('posts.index') }}'">Back</button>

    <div class="postbox {{$post->type}}">
        <div class="postbox__header">
            <img src="../imgs/default_profile_pic.jpg" alt="Profile Picture">
            <a href="{{ route('users.show', ['user' => $post->postable->user->id]) }}">
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
                @if( pathinfo(storage_path($post->imagePath))['extension'] == "mp4" )
                    <video id="post-video" controls>
                        <source src="{{ asset('storage/user_content/' . $post->imagePath) }}">
                    </video>
                @else
                    <img id="post-photo" src="{{ asset('storage/user_content/' . $post->imagePath) }}">
                @endif
            @endif
        </div>
        <div class="postbox__comment-section">
            <hr>
            <div class="title-with-icon">
                <img class="img-icon" src="../imgs/comment.png" alt="Comment">
                <h2>Comments</h2>
            </div>  
            @foreach($comments as $comment)
                @if($comment->post->id == $post->id)
                    <div class="postbox__comment">
                        <img src="../imgs/default_profile_pic.jpg" alt="Profile Picture">
                        <a href="">{{$comment->commentable->user->name}}</a>
                        <p>{{$comment->body}}</p>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
@endsection

