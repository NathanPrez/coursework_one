@extends('layouts.app')

@section('content')
    <form id="post-form" method="post" action="{{route('posts.store')}}">
        @csrf
        <div class="row space-bottom">
            <div class="col-md-2 mx-auto">Post Type:</div>
            <div class="col-md-8 content-div mx-auto">        
                <select name="type">
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

        <div id="image-upload" class="row hidden">
            <div class="col-md-2 mx-auto">Image:</div>
            <div class="col-md-8 content-div mx-auto">        
                <textarea name="body"></textarea>
            </div>
        </div>
        
        <input class="button--submit" type="submit">
    </form>
@endsection


@section('js')
    <script src="{{ URL::asset('js/create_post.js') }}"></script>
@endsection