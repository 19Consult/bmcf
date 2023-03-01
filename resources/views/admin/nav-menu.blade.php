@include('layouts.message-alert',['classes'=>'pt-0 pb-4 px-2'])
<nav class="nav">
    <div class="nav__logo"><img src="{{asset("img/logo_dashboard.svg")}}" alt="logo"></div>
    <div class="nav__back"><a href="{{route("admin.dashboard")}}">Go Back</a><span>{{$title_page}}</span></div>
    <div class="nav__right"><a class="btn btn--solid btn--arrow send" href="#">Export SCV</a></div>
</nav>
