@extends('layouts.app')

@section('content')
    <form id="post-form" method="post" action="{{route('posts.store')}}">
        @csrf
        <div class="row space-bottom">
            <div class="col-md-2 mx-auto">Post Type:</div>
            <div class="col-md-8 content-div mx-auto">        
                <select id="type" name="type" onchange="checkType()">
                    <option value="shot">Shot</option>
                    <option value="chat">Chat</option>
                    <option value="meet">Meet</option>
                    <option value="spot">Spot</option>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col-md-2 mx-auto">Content:</div>
            <div class="col-md-8 content-div mx-auto">        
                <textarea name="body"></textarea>
            </div>
        </div>

        <div id="image-upload" class="row">
            <div class="col-md-2 mx-auto">Image:</div>
            <div class="col-md-8 content-div mx-auto">        
                <textarea name="body"></textarea>
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

        function hide(name) {
            document.getElementById(name).classList.add("hide");
        }

        function show(name) {
            var elem = document.getElementById(name).classList;
            if (elem.contains("hide")) {
                document.getElementById(name).classList.remove("hide");
            }
        }

        function checkType(){
            console.log(document.getElementById("type").value);
            if(document.forms["post-form"]["type"].value == "shot") {
                show("image-upload");
            } else { 
                hide("image-upload");
            }
        }
    </script>
@endsection