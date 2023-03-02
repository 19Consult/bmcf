@extends('layouts.app')

@section('content')
    <main class="wrapper account-deletion-confirmation">
        <div class="dashboard-wrapper">
            @include("layouts.sidebar")
            <div class="profile__wrapper">
                <div class="text-rb">Are you sure you want to delete your account?</div>
                <form action="{{route("sendDeleteAccount")}}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn--solid delete-account send">Delete account</button>
                </form>

            </div>
        </div>
    </main>
@endsection
