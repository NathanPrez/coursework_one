@extends('layouts.app')

@section('content')
    <form id="post-form" method="post" action="{{route('posts.store')}}" enctype="multipart/form-data">
        @csrf
        <div class="row space-bottom">
            <div class="col-md-2 mx-auto">Post Type:</div>
            <div class="col-md-8 content-div mx-auto">        
                <select name="type" onchange="checkType()">
                    <option value="shot" selected>Shot</option>
                    <option value="chat">Chat</option>
                    <option value="meet">Meet</option>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col-md-2 mx-auto">Content:</div>
            <div class="col-md-8 content-div mx-auto">        
                <textarea name="body" required></textarea>
            </div>
        </div>
    
        <div id="image-upload" class="row">
            <div class="col-md-2 mx-auto">Video / Image:</div>
            <div class="col-md-8 content-div mx-auto">        
                <input type="file" name="file" required>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-2 mx-auto"></div>
            <div class="col-md-8 content-div mx-auto">        
                <input type="submit">
            </div>
        </div>
    </form>
@endsection


@section('js')
    <script>
        //Called whenever the select is changed
        //Checks if post is of type 'Shot'
        //if so display file upload, otherwise hide
        function checkType(){
            if(document.forms["post-form"]["type"].value == "shot") {
                show("image-upload");
                document.forms["post-form"]["file"].setAttribute("required", "");
            } else { 
                hide("image-upload");
                document.forms["post-form"]["file"].removeAttribute("required");
            }
        }
    </script>
@endsection