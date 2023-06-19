@extends('layouts.app')

@section('content')

<main class="wrapper home-page sign-in">
    <div class="container">
        <div class="home-page__top">
            <div class="home-page__top-logo"><a href="{{route("welcome")}}"><img src="{{asset("img/logo.svg")}}" alt="Logo"></a></div><a class="home-page__top-sign-in btn btn--border" href="#">sign IN</a>
        </div>
        <div class="home-page__middle-wrapper">
            <div class="home-page__middle">
                <div class="col left">
                    <div class="home-page__title-top">Already Have an Account?</div>
                    <h2 class="home-page__title">Sign In</h2>
                </div>
                <div class="col right">
                    <form class="type-1" method="POST" action="{{ route('login') }}">
                        @csrf

                        @if (session('error'))
                            <div class="alert alert-danger login-error">
                                {{ session('error') }}
                            </div>
                        @endif

                        <div class="form_input_wrap">

                            @error('email')
                            <span class="invalid-feedback error-message" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                            <input type="mail" id="email" placeholder="Your Email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            <label for="email">Email</label>
                        </div>
                        <div class="form_input_wrap password">

                            @error('password')
                            <span class="invalid-feedback error-message" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                            <input type="password" id="password" placeholder="Your Password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                            <label for="password">Password</label>
                            <input class="show-password" type="checkbox">
                        </div>

                        @if (Route::has('password.request'))
                            <a class="btn--link" href="{{ route('password.request') }}">Forgot Password?</a>
                        @endif

                        <button class="btn btn--solid btn--arrow">Sign In</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

@endsection


