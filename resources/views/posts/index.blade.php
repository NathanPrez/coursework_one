@extends('layouts.app')

@section('content')
    @foreach($posts as $post)
        <div class="postbox {{$post->type}}" onclick="location.href=''">
            <div class="postbox__header">
                <img src="../imgs/default_profile_pic.jpg" alt="Profile Picture">
                <a href="">{{$post->postable->user->name}}</a>
            </div>
            <div class="postbox__content">
                <p>{{$post->body}}</p>
            </div>
            <div class="postbox__comment-section">
                <hr>
                <div class="title-with-icon">
                    <img class="img-icon" src="../imgs/comment.png" alt="Comment">
                    <h2>Comments</h2>
                </div>  
                <div class="postbox__comment">
                    <img src="../imgs/default_profile_pic.jpg" alt="Profile Picture">
                    <a href="">sk8goat</a>
                    <p>I Loved the 'Lorem' part</p>
                </div>
            </div>
        </div>
    @endforeach
@endsection