@extends('layouts.app')

@section('content')
    <!-- Showing full post -->
    <button class="back" onclick="location.href='{{ route('posts.index') }}'">Back</button>
    
    <div class="postbox {{$post->type}}">
        <div class="postbox__header">
            <img src="../imgs/default_profile_pic.jpg" alt="Profile Picture">
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
                @if( pathinfo(storage_path($post->imagePath))['extension'] == "mp4" )
                    <video id="post-video" controls>
                        <source src="{{ asset('storage/user_content/' . $post->imagePath) }}">
                    </video>
                @else
                    <img id="post-photo" src="{{ asset('storage/user_content/' . $post->imagePath) }}">
                @endif
            @endif
        </div>
        <!-- Comments only showed on this view, index only shows post content -->
        <div class="postbox__comment-section">
            <hr>
            <div class="title-with-icon">
                <img class="img-icon" src="../imgs/comment.png" alt="Comment">
                <h2>Comments</h2>
            </div>
            <div id="comments">
                <div class="postbox__comment" v-for="comment in comments">
                    <img src="../imgs/default_profile_pic.jpg" alt="Profile Picture">
                    <a disabled>@{{ comment.commentable.username }}</a>
                    <p>@{{ comment.body }}</p>
                </div>
            </div>
        </div>
    </div>


    <script>
        var app = new Vue ({
            el: "#comments",
            data: {
                comments: [],
            },
            mounted() {
                axios.get("{{ route('api.comments.index') }}")
                    .then(response=> {
                        this.comments = response.data;
                    })
                    .catch(response=>{
                        console.log(response);
                    })
            }

        });
    </script>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
@endsection


