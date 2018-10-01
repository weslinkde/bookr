<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1">

        <title>App</title>

        <link rel="icon" type="image/ico" href="">

        <!-- Local -->
        <link rel="stylesheet" type="text/css" href="/css/raw.min.css">
        <link rel="stylesheet" type="text/css" href="/css/app.css">

        @yield('stylesheets')
    </head>
    <body>
        @include("layouts.navigation")

        @include('partials.errors')
        @include('partials.status')
        @include('partials.message')

        <div class="container-fluid">
            <div class="row" style="width: 800px; margin: 0 auto;">
                @yield("app-content")
            </div>
        </div>

        <style>
            .footer {
                position: absolute;
                bottom: 0;
                left: 0;
                width: 100%;
                /* Set the fixed height of the footer here */
                height: 60px;
                line-height: 60px; /* Vertically center the text there */
                background-color: #f5f5f5;
            }
        </style>

        <footer class="footer bg-dark" style="">
            <div class="container-fluid">
                <span class="text-muted">&copy; {!! date('Y'); !!} <a href="" style="text-decoration: none; color: inherit">Jesse Dubbink | Weslink</a>
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
        @yield("javascript")
    </body>
</html>