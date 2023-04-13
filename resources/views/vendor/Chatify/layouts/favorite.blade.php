<div class="favorite-list-item">
    @if($user)
        @php
            if(!empty($user->detail->photo) && isset($user->detail->photo)){
                $userAvatar = asset($user->detail->photo);
            }else{
                $userAvatar = Chatify::getUserWithAvatar($user)->avatar;
            }
        @endphp

        <div data-id="{{ $user->id }}" data-action="0" class="avatar av-m"
            style="background-image: url('{{ $userAvatar }}');">
        </div>
        <p>{{ strlen($user->name) > 5 ? substr($user->name,0,6).'..' : $user->name }}</p>
    @endif
</div>
