@extends('layouts.app')

@section('content')
    
    <div class="postbox shot">
        <div class="postbox__header">
            <img src="../imgs/default_profile_pic.jpg" alt="Profile Picture">
            <a href="">Hello_There</a>
        </div>
        <div class="postbox__content">
            <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Quos quia temporibus, minus culpa dicta consectetur quibusdam veritatis vitae saepe facere eos enim voluptatem iusto voluptatum. Libero modi vel magnam ex!</p>
        </div>
        <div class="postbox__comment-section">
            <hr>
            <div class="title-with-icon">
                <img class="img-icon" src="../imgs/comment.png" alt="Comment">
                <h2>Comments</h2>
            </div>  
            <hr>
            <div class="postbox__comment">
                <img src="../imgs/default_profile_pic.jpg" alt="Profile Picture">
                <a href="">Hello_There</a>
                <p>What a great post</p>
            </div>
        </div>
    </div>

    <div class="postbox spot">
        <p>Mad Spot Still</p>                
    </div>

    <div class="postbox meet">
        <p>sk8 park @2</p>                
    </div>
@endsection