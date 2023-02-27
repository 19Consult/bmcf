@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>
                <a href="{{route("logout")}}" style="color: red">Logout</a>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    {{ __('You are logged in!') }}
                </div>
            </div>

            <ul style="
                    border: 1px solid;
                    margin: 15px 0px;
                ">
                <li style="padding: 5px 0px;"><a href="{{route('profile')}}">Profile</a> </li>
            </ul>

        </div>
    </div>
</div>
@endsection
