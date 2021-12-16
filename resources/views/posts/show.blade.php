@extends('layouts.app')

@section('content')
    <!-- Showing full post -->
    <button class="back" onclick="location.href='{{ route('posts.index') }}'">Back</button>
    
    <div class="postbox {{$post->type}}">
        <div class="postbox__header">
            <div class="row">
                <div class="col-sm-9 col-8 my-auto">
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
                @auth
                    @if ($userId == $post->postable->id or $userType == "AdminProfile")
                        <div class="col-sm-3 col-4 my-auto centre edit-buttons">
                            <a onclick="show('post-change');hide('post-content');">Edit</a>
                            <a data-toggle="modal" data-target="#deletePostModal">Delete</a>
                        </div>
                    @endif
                @endauth
            </div>
        </div>
        <div id="post-content" class="postbox__content">
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

        <div id="post-change" class="postbox__content hide">
            <form method="post" action="{{ route('posts.update', ['post' => $post]) }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-lg-2 col-sm-4">Content:</div>
                    <div class="col-sm-8 content-div">        
                        <textarea name="body">{{$post->body}}</textarea>
                    </div>
                </div>

                @if($post->type == "shot")
                    <div id="image-upload" class="row">
                        <div class="col-lg-2 col-sm-4">Video / Image:</div>
                        <div class="col-sm-8 content-div">        
                            <input type="file" name="file">
                        </div>
                    </div>
                @endif
                
                <div class="row">
                    <div class="col-lg-2 col-sm-4"></div>
                    <div class="col-sm-8 content-div">        
                        <input type="submit">
                        <input value="Cancel" type="button" onclick="hide('post-change');show('post-content');">
                    </div>
                </div>
            </form>
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
                    <!-- Check for type of user, to display username or admin id -->
                    <a v-if="comment.commentable.hasOwnProperty('username')" disabled>@{{ comment.commentable.username }}</a>
                    <a v-else disabled>Admin @{{ comment.commentable.id}}</a>
                
                    @auth
                        <!-- Check if comment owner is the user, to enabled updating -->
                        <div v-if="comment.commentable.id == {{$userId}} || {{$userType}} == 'AdminProfile'" class="row">
                            <div class="col-md-9 my-auto">
                                <p>@{{ comment.body }}</p>

                                <form class="hide" method="post" action="{{ route('comments.update', ['post' => $post]) }}" enctype="multipart/form-data">
                                    @csrf
                                    <input name="body" v-bind:value="comment.body" type="text">
                                    <input name="commentId" class="hide" v-bind:value="comment.id" type="text">
                                    <input type="submit">
                                    <input onclick="closeEdit(this)" value="Cancel" type="button">
                                </form>
                            </div>
                            <div class="comment-change col-md-3 mx-auto centre">
                                <a onclick="openEdit(this)">Edit</a>

                                <form style="display: inline-block" method="post" action="{{ route('comments.delete', ['post' => $post]) }}">
                                    @csrf
                                    @method('DELETE')
                                    <input name="commentId" class="hide" v-bind:value="comment.id" type="text">
                                    <a onclick="this.parentNode.submit();">Delete</a>
                                </form>
    
                            </div>
                        </div>
                        <!-- If not owner, just display message -->
                        <div v-else>
                            <p>@{{ comment.body }}</p>
                        </div>
                    @else
                        <!-- If not owner, just display message -->
                        <div>
                            <p>@{{ comment.body }}</p>
                        </div>
                    @endauth

                </div>

                <!-- Only those logged in can make a comment -->
                @auth
                    <div class="postbox__comment comment-creation">
                        <div class="row">
                            <div class="col-lg-11 col-sm-10 col-9 my-auto">
                                <input placeholder="Write a comment" type="text" id="body" v-model="newCommentBody">
                            </div>
                            <div class="col-lg-1 col-sm-2 col-3 mx-auto">
                                <button @click="createComment"><img src="../imgs/upload.png" width="30"></button>
                            </div>
                        </div>
                    </div>
                @endauth
            </div>
        </div>
    </div>

    <div id="deletePostModal" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <form id="delete-form" method="post" action="{{ route('posts.delete', ['post' => $post]) }}">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Post Delete</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        @method('DELETE')
                        <p>Are you sure you would like to delete? This cannot be reversed.</p>
                    </div>  
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Delete</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        var app = new Vue ({
            el: "#comments",
            data: {
                comments: [],
                @auth
                    newCommentBody: '',
                    editCommentBody:'',
                @endauth
            },
            @auth
                methods:{
                    createComment:function(){
                        axios.post("{{ route('api.comments.store', ['post'=>$post]) }}",
                        {   
                            body:this.newCommentBody,
                            userId:{{$userId}},
                            userType:'{{$userType}}',
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
