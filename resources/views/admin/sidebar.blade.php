<div class="sidebar admin-panel">
    <a href="{{route("admin.dashboard")}}"><img src="{{asset("img/icons/icon-home.svg")}}" alt="Home" /><span>Home</span></a>
    <a href="#"><img src="{{asset("img/icons/icon-cupcake.svg")}}" alt="Cupcake" /></a>
    <a href="{{route('chat')}}"><img src="{{asset("img/icons/icon-chat.svg")}}" alt="Chat" /><span>Chat</span></a>
    <a href="#"><img src="{{asset("img/icons/icon-file.svg")}}" alt="File" /></a>

    <a href="{{route("admin.reports")}}">
        <img src="{{asset("img/icons/file_report.svg")}}" alt="Report Problem" />
        <span>Report Problem</span>
    </a>

    <a href="{{route("admin.category.list")}}">
        <img src="{{asset("img/icons/icon-file.svg")}}" alt="File" />
        <span>Category</span>
    </a>
    <a href="{{route("admin.usersDelete")}}">
        <img src="{{asset("img/icons/delete-users.svg")}}" alt="Delete users" />
        <span>Delete users</span>
    </a>
    <a href="{{route("admin.users")}}">
        <img src="{{asset("img/icons/icon-user.svg")}}" alt="User" />
        <span>Users</span>
    </a>
    <a href="{{route("admin.settingsPage")}}">
        <svg width="24" height="24" viewBox="0 0 24 24">
            <path fill="#fff" d="M20.2 13.3c.1-.4.1-.8.1-1.3s0-.9-.1-1.3l2-1.5c.2-.1.3-.3.2-.5L20.8 6.2c-.1-.2-.3-.2-.5-.1l-2 1.5c-.7-.6-1.5-1-2.5-1.1V3.6c0-.3-.2-.6-.5-.6h-3.8c-.3 0-.5.3-.5.6v2.1c-1 .1-1.8.5-2.5 1.1l-2-1.5c-.2-.2-.4-.1-.5.1L3.1 9.8c-.1.2 0 .4.2.5l2 1.5c-.1.4-.1.8-.1 1.3s0 .9.1 1.3l-2 1.5c-.2.1-.3.3-.2.5l2.2 3.2c.1.2.3.2.5.1l2-1.5c.7.6 1.5 1 2.5 1.1v2.1c0 .3.2.6.5.6h3.8c.3 0 .5-.3.5-.6v-2.1c1-.1 1.8-.5 2.5-1.1l2 1.5c.2.1.4 0 .5-.1l2.2-3.2c.1-.2 0-.4-.2-.5l-2-1.5zm-7.2 2.4c-2 0-3.7-1.6-3.7-3.7s1.6-3.7 3.7-3.7 3.7 1.6 3.7 3.7-1.7 3.7-3.7 3.7z"/>
        </svg>


        <span>Settings</span>
    </a>
    <a href="{{route("logout")}}" style="margin-top: 20px">
        <img src="{{asset("img/icons/Logout.svg")}}" alt="Logout" />
        <span>Logout</span>

    </a>
</div>
