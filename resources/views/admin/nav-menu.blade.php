@include('layouts.message-alert',['classes'=>'pt-0 pb-4 px-2'])
<nav class="nav">
    <div class="nav__logo"><img src="{{asset("img/logo_dashboard.svg")}}" alt="logo"></div>
    <div class="nav__back"><a href="{{route("admin.dashboard")}}">Go Back</a><span>{{(isset($title_page) && !empty($title_page)) ? $title_page : ''}}</span></div>

    @if(app('checkNameRoute_app') == 'admin.users')
        <div class="nav__right"><a class="btn btn--solid btn--arrow send" href="{{route("admin.users.export")}}">Export SCV</a></div>
    @endif
</nav>
