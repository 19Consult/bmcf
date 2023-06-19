<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{(isset($data['title_page']) && !empty($data['title_page'])) ? $data['title_page'] : 'Admin'}}</title>

    <link rel="icon" href="{{asset("img/favicon.svg")}}" type="image/svg+xml" />
    <link rel="stylesheet" href="{{asset("css/main.css")}}" />
    <link rel="stylesheet" href="{{asset("css/admin-css.css")}}" />

    <link rel="stylesheet" href="{{asset("css/intlTelInput.min.css")}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="{{asset("Semantic/semantic.min.css")}}">
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
<script src="{{asset("js/libs/ckeditor/ckeditor.js")}}"> </script>
<script src="{{asset("Semantic/semantic.min.js")}}"></script>
<script src="{{asset("js/main.js")}}"> </script>
</body>
</html>
