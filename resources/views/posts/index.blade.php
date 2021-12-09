@extends('layouts.app')

@section('content')
    @foreach($posts as $post)
        <div class="clickable">
            <div class="postbox {{$post->type}}" onclick="location.href='{{ route('posts.show', ['id'=>$post->id]) }}'">
                <div class="postbox__header">
                    <img src="../imgs/default_profile_pic.jpg" alt="Profile Picture">
                    <a href="">{{$post->postable->username}}</a>
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
            </div>
        </div>
    @endforeach
@endsection
