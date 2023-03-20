<div class="sidebar admin-panel">
    <a href="{{route("admin.dashboard")}}"><img src="{{asset("img/icons/icon-home.svg")}}" alt="Home" /><span>Home</span></a>
    <a href="#"><img src="{{asset("img/icons/icon-cupcake.svg")}}" alt="Cupcake" /></a>
    <a href="#"><img src="{{asset("img/icons/icon-chat.svg")}}" alt="Chat" /></a>
    <a href="#"><img src="{{asset("img/icons/icon-file.svg")}}" alt="File" /></a>
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
    <a href="{{route("logout")}}" style="margin-top: 20px">
        <img src="{{asset("img/icons/Logout.svg")}}" alt="Logout" />
        <span>Logout</span>

    </a>
</div>
