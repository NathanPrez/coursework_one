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
                        <img id="post-photo" src="{{ asset('storage/user_content/' . $post->imagePath) }}" class="hide">
                        <video id="post-video" class="hide" controls>
                            <source src="{{ asset('storage/user_content/' . $post->imagePath) }}">
                        </video>
                    @endif
                </div>
            </div>
        </div>
    @endforeach
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