@include('layouts.message-alert',['classes'=>'pt-0 pb-4 px-2'])
<nav class="nav">
    <div class="nav__logo"><a href="{{route("home")}}"><img src="{{asset("img/logo_dashboard.svg")}}" alt="logo"></a></div>
    <div class="nav__title">BeMy Cofounder</div>
    <div class="nav__back"><span>{{!empty($title_page) ? $title_page : ''}}</span></div>
    <div class="nav__right">
        @if(app('checkNameRoute_app') == 'homeInvestor')
            <a class="nav__search" href="#"></a>
        @endif
        <a class="nav__notifications" href="#"></a>
        @if(!empty(Auth::user()->detail->photo))
            <div class="nav__profile-img"><img src="{{asset(Auth::user()->detail->photo)}}" alt="User"></div>
        @endif
    </div>
</nav>
