<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Bookr | Easy Room and Assets Reservation</title>

    <link rel="icon" type="image/ico" href="">

    <!-- Local -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="/css/raw.min.css">
    <link rel="stylesheet" type="text/css" href="/css/app.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/calendar.css') }}">
    @yield('stylesheets')
</head>
<body>
@include("layouts.navigation")

@include('partials.errors')
@include('partials.status')
@include('partials.message')

<div class="container-fluid">
    <div class="row">
        @yield("app-content")
    </div>
</div>

<footer class="footer bg-dark">
    <div class="container-fluid">
        <span class="text-muted">&copy; {!! date('Y'); !!} <a href="https://www.weslink.de" target="_blank" style="color: inherit">Jesse Dubbink | Weslink</a>
            @if (Session::get('original_user'))
                <a class="btn btn-link btn-sm" href="/users/switch-back">Return to your Login</a>
            @endif
        </span>
    </div>
</footer>

<script type="text/javascript">
    var _token = '{!! Session::token() !!}';
    var _url = '{!! url("/") !!}';
</script>
@yield("pre-javascript")
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script defer src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>
<script src="/js/app.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

@yield("javascript")
</body>
</html>