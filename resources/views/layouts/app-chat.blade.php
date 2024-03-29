<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">


@if(\App\Models\User::checkAdmin())
        <title>{{ config('app.name', 'COFOUNDER') }}</title>
    @else
        <title>{{\App\Models\User::getTitle()}}</title>
    @endif

    <link rel="icon" href="{{asset("img/favicon.svg")}}" type="image/svg+xml" />
    <link rel="stylesheet" href="{{asset("css/intlTelInput.min.css")}}" />
    <link rel="stylesheet" href="{{asset("css/main.css")}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

{{--    <link href="{{ asset('vendor/munafio/chatify/css/chatify.css') }}" rel="stylesheet">--}}
    <link href="{{ asset('css/chatify/style.css') }}" rel="stylesheet">
{{--    <link href="../vendor/munafio/chatify/css/chatify.css" rel="stylesheet">--}}

</head>
<body>

@yield('content')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script src="{{asset("js/libs/jquery-3.6.0.min.js")}}"></script>
<script src="{{asset("js/libs/jquery.scrollbar.min.js")}}"></script>
<script src="{{asset("js/libs/select2.min.js")}}"></script>
<script src="{{asset("js/libs/jquery.inputmask.min.js")}}"></script>
<script src="{{asset("js/libs/intlTelInput.min.js")}}"> </script>
<script src="{{asset("js/main.js")}}"> </script>

<script src="{{asset("js/libs/ckeditor/ckeditor.js")}}"> </script>
{{--    <script src="//cdn.ckeditor.com/4.20.2/standard/ckeditor.js"></script>--}}

<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script src="{{ asset('js/chatify/code.js') }}"></script>
<script src="{{ asset('js/chatify/autosize.js') }}"></script>
<script src="{{ asset('js/chatify/utils.js') }}"></script>
<script src="{{ asset('js/chatify/font.awesome.min.js') }}"></script>
{{--<script src="{{ asset('js/chatify/js/chatify.js') }}"></script>--}}

</body>
</html>
