@include('layouts.message-alert',['classes'=>'pt-0 pb-4 px-2'])
<nav class="nav">
    <div class="nav__logo"><a href="{{route("home")}}"><img src="{{asset("img/logo_dashboard.svg")}}" alt="logo"></a>></div>
    <div class="nav__title"><a href="{{route("home")}}">BeMy Cofounder</a></div>
    <div class="nav__back"><a href="{{route("home")}}">Go Back</a><span>{{$title_page}}</span></div>
    <div class="nav__right"><a class="btn btn--solid btn--arrow send" href="#" onclick="saveBtn()">Save</a></div>
</nav>
