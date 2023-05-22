@php
    use App\Http\Controllers\CustomMessagesController;
    use App\Models\NdaProjects;
    use App\Models\User;
    use App\Models\NotificationsUsers;
    use Illuminate\Support\Facades\Auth;

    $notifications = CustomMessagesController::getNotSeeMessage();

    $nda_notifications = null;
    if(User::checkOwner()){
        $nda_notifications = NdaProjects::where('owner_pr_id', auth()->id())->where('seen', false)->where('status', 'pending')->get();
    }

    $notificationsUsers = NotificationsUsers::where('user_id', Auth::id())->where('seen', false)->get();

    $check_notif = false;
    if (($notifications['unread_count'] > 0 || (!empty($nda_notifications) && count($nda_notifications->toArray()) > 0))){
        $check_notif = true;
    }elseif (!Auth::user()->hasVerifiedEmail()){
        $check_notif = true;
    }elseif (count($notificationsUsers->toArray()) > 0){
        $check_notif = true;
    }

@endphp

@include('layouts.message-alert',['classes'=>'pt-0 pb-4 px-2'])
<nav class="nav">
    <div class="nav__logo"><a href="{{route("dashboardOwner")}}"><img src="{{asset("img/logo_dashboard.svg")}}" alt="logo"></a></div>
    <div class="nav__title">BeMy Cofounder</div>
    <div class="nav__back"><span>{{!empty($title_page) ? $title_page : ''}}</span></div>
    <div class="nav__right">
        @if(app('checkNameRoute_app') == 'homeInvestor')
            <a class="nav__search" href="#"></a>
        @endif
        <div class="nav__notifications-wrap">
            <a class="nav__notifications {{ $check_notif ? 'has-notific' : 'non-notific' }}" href="{{ $check_notif ? '#' : route("notifications") }}"></a>
            <ul class="nav__notifications-popup">
                @if(!Auth::user()->hasVerifiedEmail())
{{--                    <li>Email not verified</li>--}}
                    <li>
                        <form class="form-verified" method="POST" action="{{ route('verification.resend') }}">
                            @csrf
                            <button type="submit" class="btn-verified">Email not verified</button>
                        </form>
                    </li>
                @endif
                @if($notifications['unread_count'] > 0)
                    @foreach($notifications['unseen_senders'] as $key => $val)
                        <li><a href="{{route("chat")}}" data-user-id="{{$val['id']}}">New message from {{$val['name']}}</a></li>
                    @endforeach
                @endif
                @if(!empty($nda_notifications) && isset($nda_notifications))
                        @foreach($nda_notifications as $key => $val)
                            <li><a href="{{route("ndaList")}}">New request NDA</a></li>
                        @endforeach
                @endif
                @if(!empty($notificationsUsers) && isset($notificationsUsers))
                    @foreach($notificationsUsers as $key => $val)
                        @php
                        $link = '';
                        if( !empty($val->url) ){
                            $link = url($val->url);
                        }
                        @endphp
                        <li><a class="notification-user" data-id="{{$val->id}}" href="{{$link}}">{{$val->text}}</a></li>
                    @endforeach
                @endif

                    <li><a class="see-all-notifications" href="{{route("notifications")}}">See All Notifications</a></li>
            </ul>
        </div>
        @if(!empty(Auth::user()->detail->photo))
            <div class="nav__profile-img"><img src="{{asset(Auth::user()->detail->photo)}}" alt="User"></div>
        @endif
    </div>
</nav>
