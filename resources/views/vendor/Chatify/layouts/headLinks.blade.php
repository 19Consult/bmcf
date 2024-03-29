
@if(\App\Models\User::checkAdmin())
    <title>{{ config('app.name', 'COFOUNDER') }}</title>
@elseif(\App\Models\User::checkInvestor())
    <title>Angel</title>
@else
    <title>{{\App\Models\User::getTitle()}}</title>
@endif

<link rel="icon" href="{{asset("img/favicon.svg")}}" type="image/svg+xml" />

{{-- Meta tags --}}
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="id" content="{{ $id }}">
<meta name="messenger-color" content="{{ $messengerColor }}">
<meta name="messenger-theme" content="{{ $dark_mode }}">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="url" content="{{ url('').'/'.config('chatify.routes.prefix') }}" data-user="{{ Auth::user()->id }}">

{{-- scripts --}}
<script
  src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('js/chatify/font.awesome.min.js') }}"></script>
<script src="{{ asset('js/chatify/autosize.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>
<script src='https://unpkg.com/nprogress@0.2.0/nprogress.js'></script>
<script src="{{asset("js/main.js")}}"> </script>

{{-- styles --}}
<link rel='stylesheet' href='https://unpkg.com/nprogress@0.2.0/nprogress.css'/>
<link href="{{ asset('css/chatify/style.css') }}" rel="stylesheet" />
<link href="{{ asset('css/chatify/'.$dark_mode.'.mode.css') }}" rel="stylesheet" />
<link href="{{ asset('css/app.css') }}" rel="stylesheet" />

<link rel="stylesheet" href="{{asset("css/main.css")}}" />
<link rel="stylesheet" href="{{asset("css/main_chat.css")}}" />

@if(App\Models\User::checkAdmin())
    <link rel="stylesheet" href="{{asset("css/admin-css.css")}}" />
@endif

{{-- Setting messenger primary color to css --}}
<style>
    :root {
        --primary-color: {{ $messengerColor }};
    }
</style>
