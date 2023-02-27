@extends('layouts.app')

@section('content')

    <main class="wrapper home-page sign-in sign-up-founder">
        <div class="container">
            <div class="home-page__top">
                <div class="home-page__top-logo"><a href="{{route("welcome")}}"><img src="{{asset("img/logo.svg")}}" alt="Logo"></a></div><a class="home-page__top-sign-in btn btn--border" href="{{route("login")}}">sign IN</a>
            </div>
            <div class="home-page__middle-wrapper">
                <div class="home-page__middle">
                    <div class="col left">
                        <div class="home-page__title-top">Create A FOUNDER account</div>
                        <h2 class="home-page__title">Sign Up</h2>
                    </div>
                    <div class="col right">
                        <form class="type-1" method="POST" action="{{ route('sign-up-founder') }}">
                            @csrf
                            <div class="form_input_wrap">
                                @error('email')
                                    <span class="invalid-feedback error-message" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <input type="mail" id="email" placeholder="Your Email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                                <label for="email">Email</label>
                            </div>
                            <div class="form_input_wrap password">
                                @error('password')
                                    <span class="invalid-feedback error-message" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <input type="password" id="password" placeholder="Your Password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                <label for="password">Password</label>
                                <input class="show-password" type="checkbox">
                            </div>
                            <div class="form_input_wrap password">
                                <input type="password" id="password" placeholder="Your Password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                <label for="password">Repeat password</label>
                                <input class="show-password" type="checkbox">
                            </div>
                            <input type="hidden" name="roidle" value="{{$role_md5}}">
                            <button type="submit" class="btn btn--solid btn--arrow">Register</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

@endsection
