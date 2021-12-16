<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">  
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <meta http-equiv="X-UA-Compatible" content="ie=edge"> 

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" 
            integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" 
            crossorigin="anonymous">
        <link rel="stylesheet" href="{{ URL::asset('css/master.css') }}">
        <!-- For page specific css -->
        @yield('css')

        <title>SK8</title>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script type="text/javascript" src="{{ URL::asset('js/master.js') }}"></script>

        <!-- Page specific JS -->
        @yield('js')
    </head>

    <body>
        <!-- Navigation bar -->
        <nav class="navbar navbar-expand-md navbar-dark">
            <!-- Logo -->
            <a class="navbar-brand nav-link" disabled>
                <img src=" {{ URL::asset('imgs/logo.png') }} " alt="Logo" width="75" height="75">
            </a>

            <!-- Collapse Burger Button -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Links -->
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item"> <a class="nav-link" href="{{ route('posts.index') }}">Cruise</a> </li>
                    @auth
                        <!-- Only logged in users can view their profile/upload -->
                        <li class="nav-item"> <a class="nav-link" href="{{ route('users.show', ['user' => auth()->user()]) }}">My Deck</a> </li>
                        <li class="nav-item"> <a class="nav-link" href="{{ route('posts.create') }}">Create Post</a> </li>
                        <li class="nav-item"> <a class="nav-link" href="{{ route('users.notifications', ['user' => auth()->user()]) }}">Notifications</a> </li>
                    @endauth
                </ul>

                <!-- Login / Logout links -->
                <!-- Float right as they're not inside the 'navbar-nav' li -->
                @guest
                    <a class="nav-link nav-item" href="{{ route('login') }}">Log in</a>

                    @if (Route::has('register'))
                        <a class="nav-link nav-item" href="{{ route('register') }}">Register</a>
                    @endif
                @else
                    <form id="logout-form" method="post" action="{{ route('users.logout') }}">
                        @csrf
                        <a class="nav-link nav-item" onclick="submit()">Log Out</a> 
                    </form>
                @endguest
            </div>
        </nav>

        <div class="parent-wrap">
            <div class="background-image"></div>
            <div class="content">
                <div class="container main-content">

                    @if ($errors->any()) 
                        <div class="error">
                            Error: 
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                     @yield('content')
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    </body>
</html>
