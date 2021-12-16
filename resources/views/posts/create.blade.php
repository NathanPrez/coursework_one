@extends('layouts.app')

@section('content')
    <!-- Post Creation -->
    <form id="post-form" method="post" action="{{route('posts.store')}}" enctype="multipart/form-data">
        @csrf

        <!-- Post Type -->
        <div class="row space-bottom">
            <div class="col-lg-2 col-sm-4 mx-auto">Post Type:</div>
            <div class="col-sm-8 content-div">
                <!-- checkType will hide/show certain input fields -->           
                <select name="type" onchange="checkPostType()">
                    <!-- If failed submission, get old value --> 
                    @if(old('type') == 'chat')
                        <option value="shot">Shot</option>
                        <option value="chat" selected>Chat</option>
                        <option value="meet">Meet</option>
                    @elseif(old('type') == 'meet')
                        <option value="shot">Shot</option>
                        <option value="chat">Chat</option>
                        <option value="meet" selected>Meet</option>
                    @else
                        <option value="shot" selected>Shot</option>
                        <option value="chat">Chat</option>
                        <option value="meet">Meet</option>
                    @endif
                </select>
            </div>
        </div>

        <!-- Post Content -->
        <div class="row">
            <div class="col-lg-2 col-sm-4 mx-auto">Content:</div>
            <div class="col-sm-8 content-div">        
                <textarea name="body" required>{{ old('body')}}</textarea>
            </div>
        </div>
    
        <!-- Post file, if needed -->
        <div id="image-upload" class="row">
            <div class="col-lg-2 col-sm-4 mx-auto">Video / Image:</div>
            <div class="col-sm-8 content-div">        
                <input type="file" name="file" required>
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