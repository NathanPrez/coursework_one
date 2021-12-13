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

        <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.24.0/axios.min.js" 
        integrity="sha512-u9akINsQsAkG9xjc1cnGF4zw5TFDwkxuc9vUp5dltDWYCSmyd0meygbvgXrlc/z7/o4a19Fb5V0OUE58J7dcyw==" 
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
        <!-- Comments only showed on this view, index only shows post content -->
        <div class="postbox__comment-section">
            <hr>
            <div class="title-with-icon">
                <img class="img-icon" src="../imgs/comment.png" alt="Comment">
                <h2>Comments</h2>
            </div>
            <div id="comments">
                <div class="postbox__comment" v-for="comment in comments">
                    <img class="profile-pic" src="../imgs/default_profile_pic.jpg" alt="Profile Picture">
                    <a disabled>@{{ comment.commentable.username }}</a>
                    <p>@{{ comment.body }}</p>
                </div>
                @auth
                    <div class="postbox__comment comment-creation">
                        <div class="row">
                            <div class="col-md-11 my-auto">
                                <input placeholder="Write a comment" type="text" id="body" v-model="newCommentBody">
                            </div>
                            <div class="col-md-1 mx-auto">
                                <button @click="createComment"><img src="../imgs/upload.png" width="30"></button>
                            </div>
                        </div>
                    </div>
                @endauth
            </div>
        </div>
    </div>
    <script>
        var app = new Vue ({
            el: "#comments",
            data: {
                comments: [],
                @auth
                    newCommentBody: '',
                    newCommentId: {{$userId}},
                    newCommentUserType: '{{$userType}}',
                @endauth
            },
            @auth
                methods:{
                    createComment:function(){
                        axios.post("{{ route('api.comments.store', ['post'=>$post]) }}",
                        {   
                            body:this.newCommentBody,
                            userId:this.newCommentId,
                            userType:this.newCommentUserType,
                        })
                        .then(response=>{
                            this.comments = response.data;
                            this.newCommentBody='';
                        })
                        .catch(response=>{
                            console.log(response);
                        })
                    }
                },
            @endauth
            mounted() {
                axios.get("{{ route('api.comments.index', ['post' => $post]) }}")
                    .then(response => {
                        this.comments = response.data;
                    })
                    .catch(response =>{
                        console.log("This aint work");
                        console.log(response);
                    })
            }

        });
    </script>
@endsection


