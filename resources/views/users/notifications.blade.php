@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ URL::asset('css/user.css') }}">
@endsection

@section('content')
    <button onclick="location.href='{{ route('posts.index') }}'">Back</button>

    <h1 class="centre">Notifications</h1>
    @foreach($nots as $not)
        <div class="userbox notbox" onclick="location.href='{{ route('posts.show', ['post'=>  $not->post_id]) }}'">
            {{$not->notification}}
        </div>
    @endforeach
@endsection