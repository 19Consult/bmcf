@extends('layouts.app')

@section('content')
    <main class="wrapper home">
        @include("layouts.nav-menu-home")
        <div class="dashboard-wrapper">
            @include("layouts.sidebar")
            <div class="profile__wrapper">

            </div>
        </div>
    </main>
@endsection
