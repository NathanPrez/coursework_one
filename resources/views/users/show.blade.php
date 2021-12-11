@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ URL::asset('css/user.css') }}">
@endsection

@section('content')
    <div class="userbox">
        <div class="row">
            <div class="col-md-4 mx-auto centre">
                @if($user->userProfile == null)
                    <img src="../imgs/admin_profile_pic.jpg" alt="Admin Profile Picture">
                    <h2>Admin {{$user->adminProfile->id}}</h2>
                @else
                    @if($user->userProfile->profilePicturePath == "default_profile_pic.jpg")
                        <img src="../imgs/default_profile_pic.jpg" alt="User Profile Picture">
                    @else
                        <img src="{{ asset('storage/user_content/' . $user->userProfile->profilePicturePath) }}" alt="User Profile Picture">
                    @endif
                @endif
            </div>
            <div class="col-md-8 my-auto">
                @if($user->userProfile == null)
                    <h2>Admin {{ $user->adminProfile->id }}</h2>
                @else
                    <h2>{{ $user->userProfile->username }}</h2>
                    <p>{{ $user->userProfile->bio }}</p>
                @endif
            </div>
        </div>
        
        <p></p>
    </div>
@endsection

