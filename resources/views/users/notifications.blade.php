@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ URL::asset('css/user.css') }}">
@endsection

@section('content')
    <button onclick="location.href='{{ route('posts.index') }}'">Back</button>

    <h1 class="centre">Notifications</h1>
    @foreach($nots as $not)
        <div class="userbox notbox" onclick="location.href='{{ route('posts.show', ['post'=>  $not->post_id]) }}'">
            <div class="row">
                <div class="col-md-10">
                    {{$not->notification}}
                </div>
                <div class="class-md-2">
                    <form method="post" action="{{ route('notifications.delete', ['not' =>  $not]) }}">
                        @csrf
                        @method('DELETE')
                        <input value="Delete" type="submit">
                    </form>
                    
                </div>
            </div>

            
        </div>
    @endforeach
@endsection