@extends('admin.loyout')

@section('content')
    <main class="wrapper dashboard">
{{--        @include("admin.nav-menu", ['title_page' => $data['title_page']])--}}
        <div class="dashboard-wrapper">
            @include("admin.sidebar")
            <div class="profile__wrapper">

            </div>
        </div>
    </main>
@endsection
