<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">  
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <meta http-equiv="X-UA-Compatible" content="ie=edge"> 

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" href="{{ URL::asset('css/master.css') }}">

        <title>SK8</title>

        @yield('js')


    </head>
    <body>
        <nav class="navbar navbar-expand-sm navbar-dark">
            <div class="container">
                <a class="navbar-brand nav-link" disabled>
                    <img src=" {{ URL::asset('imgs/logo.png') }} " alt="Logo" width="75" height="75">
                    <!-- <img src=" {{ URL::asset('imgs/logo_hover.png') }} " alt="Logo Hover" width="75" height="75"> -->
                </a>

                <!-- Collapse Burger Button -->
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Links -->
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item"> <a class="nav-link" href="{{route('posts.index')}}">Cruise</a> </li>
                        <li class="nav-item"> <a class="nav-link" href="#">My Deck</a> </li>
                        <li class="nav-item"> <a class="nav-link" href="{{route('posts.create')}}">Post</a> </li>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="parent-wrap">
            <div class="background-image"></div>
            <div class="content">
                <div class="container">
                     @yield('content')
                </div>
            </div>
        </div>
    
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    </body>
</html>
