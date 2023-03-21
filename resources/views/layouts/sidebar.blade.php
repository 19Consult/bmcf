<div class="sidebar">
    <a href="" style="pointer-events: none; opacity: 0.2;"><img src="{{asset("img/icons/icon-home.svg")}}" alt="Home" /></a>
    <a href="{{route("home")}}"><img src="{{asset("img/icons/icon-cupcake.svg")}}" alt="Cupcake" /></a>

    @if(App\Models\User::checkInvestor() && false)
        <a class="favorite-link-sidebar" href="{{route("viewProjectFavorites")}}">
            <svg width="20" height="18" viewBox="0 0 20 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M17.57 2.44a4.91 4.91 0 010 6.93L10 17 2.43 9.37A4.91 4.91 0 015.87 1a4.9 4.9 0 013.44 1.44c.266.263.498.559.69.88a4.46 4.46 0 01.69-.88 4.83 4.83 0 016.88 0v0z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </a>
    @endif

    <a href="#"><img src="{{asset("img/icons/icon-chat.svg")}}" alt="Chat" /></a>
    <a href="#"><img src="{{asset("img/icons/icon-file.svg")}}" alt="File" /></a>
    <a href="{{route("profile")}}"><img src="{{asset("img/icons/icon-user.svg")}}" alt="User" /></a>
    <a href="{{route("logout")}}"><img src="{{asset("img/icons/Logout.svg")}}" alt="Logout" /></a>

</div>
