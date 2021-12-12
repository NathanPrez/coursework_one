@extends('layouts.app')

@section('content')
    <!-- Profile creation -->
    <form id="user-form" method="post" action="{{route('users.store')}}" enctype="multipart/form-data">
        @csrf
        <div class="row space-bottom">
            <div class="col-lg-2 col-sm-4 mx-auto">Profile Type:</div>
            <div class="col-sm-8 content-div">     
                <!-- checkType will hide/show certain input fields -->   
                <select name="type" onchange="checkType()">
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
        </div>

        <div id="username-input" class="row space-bottom">
            <div class="col-lg-2 col-sm-4 mx-auto">Username:</div>
            <div class="col-sm-8 content-div">        
                <input type="text" name="username" value="{{old('age')}}" required>
            </div>
        </div>
    
        <div class="row">
            <div class="col-lg-2 col-sm-4 mx-auto">Profile Picture:</div>
            <div class="col-sm-8 content-div">        
                <input type="file" name="file">
            </div>
        </div>

        <div id="bio-input" class="row space-bottom">
            <div class="col-lg-2 col-sm-4 mx-auto">Bio:</div>
            <div class="col-sm-8 content-div">        
                <textarea name="bio"></textarea>
            </div>
        </div>
    
        
        <div class="row">
            <div class="col-lg-2 col-sm-4 mx-auto"></div>
            <div class="col-sm-8 content-div">        
                <input type="submit">
            </div>
        </div>
    </form>
@endsection

@section('js')
    <script>
        //Called whenever the select is changed
        //Checks if post is of type 'user'
        //if so display username change and bio
        function checkType(){
            if(document.forms["user-form"]["type"].value == "user") {
                show("username-input");
                show("bio-input");
                document.forms["user-form"]["username"].setAttribute("required", "");
            } else { 
                hide("username-input");
                hide("bio-input");
                document.forms["user-form"]["username"].removeAttribute("required");
            }
        }
    </script>
@endsection