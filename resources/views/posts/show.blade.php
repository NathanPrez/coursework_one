@extends('layouts.app')

@section('content')
    <div class="postbox {{$post->type}}">
        <div class="postbox__header">
            <img src="../imgs/default_profile_pic.jpg" alt="Profile Picture">
            <a href="">{{$post->postable->user->name}}</a>
        </div>
        <div class="postbox__content">
            <p>{{$post->body}}</p>
            @if($post->type == "shot")
                <img id="post-photo" src="{{ asset('storage/user_content/' . $post->imagePath) }}" class="hide">
                <video id="post-video" class="hide" controls>
                    <source src="{{ asset('storage/user_content/' . $post->imagePath) }}">
                </video>
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

@section('js-end')
    <script>
        var filetype = '{{ $post->imagePath }}'.split('.').pop();
        console.log(filetype);
        if (filetype == "mp4") 
        {
            show("post-video");
        }
        else 
        {
            show("post-photo");
        }
    </script>
@endsection
