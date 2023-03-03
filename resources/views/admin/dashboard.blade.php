@extends('admin.loyout')

@section('content')
    <main class="wrapper dashboard">
        @include("layouts.nav-menu-home")
        <div class="dashboard-wrapper">
            @include("admin.sidebar")
            <div class="profile__wrapper">

            </div>
        </div>
    </main>
@endsection
