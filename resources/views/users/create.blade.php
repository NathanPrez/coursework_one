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
                    @if(old('type') == 'admin')
                        <option value="user">User</option>
                        <option value="admin" selected>Admin</option>
                    @else
                        <option value="user" selected>User</option>
                        <option value="admin">Admin</option>
                    @endif
                </select>
            </div>
        </div>

        <!-- Username, if applicable -->
        <div id="username-input" class="row space-bottom">
            <div class="col-lg-2 col-sm-4 mx-auto">Username:</div>
            <div class="col-sm-8 content-div">        
                <input type="text" name="username" value="{{old('username')}}" required>
            </div>
        </div>
        
        <!-- Username -->
        <div class="row">
            <div class="col-lg-2 col-sm-4 mx-auto">Profile Picture:</div>
            <div class="col-sm-8 content-div">        
                <input type="file" name="file">
            </div>
        </div>

        <!-- bio, if applicable -->
        <div id="bio-input" class="row space-bottom">
            <div class="col-lg-2 col-sm-4 mx-auto">Bio:</div>
            <div class="col-sm-8 content-div">        
                <textarea name="bio">{{old('bio')}}</textarea>
            </div>
        </div>
    
        <!-- Submit -->
        <div class="row">
            <div class="col-lg-2 col-sm-4 mx-auto"></div>
            <div class="col-sm-8 content-div">        
                <input type="submit">
            </div>
        </div>
    </form>
@endsection
