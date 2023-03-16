@include('layouts.message-alert',['classes'=>'pt-0 pb-4 px-2'])
<nav class="nav">
    <div class="nav__logo"><a href="{{route("home")}}"><img src="{{asset("img/logo_dashboard.svg")}}" alt="logo"></a></div>
    <div class="nav__title">BeMy Cofounder</div>
    <div class="nav__back"><span>{{$title_page}}</span></div>
    <div class="nav__right"><a class="nav__notifications" href="#"></a>
        @if(!empty($data['user_photo']))
            <div class="nav__profile-img"><img src="{{asset($data['user_photo'])}}" alt="User"></div>
        @endif
    </div>
</nav>
