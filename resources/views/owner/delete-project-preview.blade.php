@extends('layouts.app')

@section('content')
    <main class="wrapper account-deletion-confirmation">
        <div class="dashboard-wrapper">
            @include("layouts.sidebar")
            <div class="profile__wrapper">
                <div class="text-rb">Are you sure you want to delete the project?</div>
                <form action="{{route("deleteProject")}}" method="POST">
                    @csrf
                    <input type="hidden" name="id_project" value="{{$id_project}}">
                    <button type="submit" class="btn btn--solid delete-account send">Delete project</button>
                </form>

            </div>
        </div>
    </main>
@endsection
