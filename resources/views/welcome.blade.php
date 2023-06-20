@extends('layouts.app')

@section('content')

@php
    $role_token = app("roleIdMD5_register");
    $role_md5 = $role_token[2];
@endphp

<main class="wrapper home-page">
    <div class="container">
        <div class="home-page__top">
            <div class="home-page__top-logo"><img src="{{asset("img/logo.svg")}}" alt="Logo"></div><a class="home-page__top-sign-in btn btn--border" href="{{ route('login') }}">sign IN</a>
        </div>
        <div class="home-page__middle">
            <div class="col left">
                <div class="home-page__middle-left">
                    <div class="home-page__title-top">Looking FOR</div>
                    <h2 class="home-page__title">COFOUNDERS?</h2>
                    <div class="home-page__descr-wrapper">
                        <div class="home-page__descr-title">time to move forward-fast</div>
                        <div class="home-page__descr">Being a founder can be a lonely business and hard work is seldom enough to guarantee success. BeMyCoFounder is a FREE platform to help match you with the experts your project needs.</div>
                    </div>
                </div>

                <div class="home-page__middle-right">
                    <div class="home-page__title-top">WANT TO BE A</div>
                    <h2 class="home-page__title">COFOUNDER?</h2>
                    <a class="btn btn--border" href="{{ route('sign-up-co-founder') }}">START HERE</a>
                    <div class="home-page__descr-wrapper">
                        <div class="home-page__descr-title">True value of you</div>
                        <div class="home-page__descr">Realise the full value of your skills, market knowledge and experience with BeMyCoFounder. Free sign up will connect you with unique opportunities to team up with innovators and start-ups to do what you love and on your terms.</div>
                    </div>
                </div>
            </div>
            <div class="col right">
                <div class="right-title">Join BeMyCoFounder.com for FREE <br> and Find Your A-Team!</div>
                <div class="right-descr">Add your project today and connect with those fit your ambition.</div>
                <form class="type-1" method="POST" action="{{ route('sign-up-co-founder') }}">
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
        <div class="home-page__bottom">
            <div class="home-page__bottom-links"><a href="#">privacy</a><a href="#">Terms & Conditions</a></div>
            <div class="copyright">(c) {{date('Y')}} BeMyCoFounder</div>
        </div>
    </div>
</main>

@endsection
