<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'COFOUNDER') }}</title>
    <link rel="icon" href="{{asset("img/favicon.svg")}}" type="image/svg+xml" />
    <link rel="stylesheet" href="{{asset("css/main.css")}}" />
</head>
<body>

@yield('content')

<script src="{{asset("js/libs/jquery-3.6.0.min.js")}}"></script>
<script src="{{asset("js/libs/jquery.scrollbar.min.js")}}"></script>
<script src="{{asset("js/libs/select2.min.js")}}"></script>
<script src="{{asset("js/libs/jquery.inputmask.min.js")}}"></script>
<script src="{{asset("js/main.js")}}"> </script>
</body>
</html>
