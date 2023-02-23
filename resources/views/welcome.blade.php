@extends('layouts.app')

@section('content')

<main class="wrapper home-page">
    <div class="container">
        <div class="home-page__top">
            <div class="home-page__top-logo"><img src="{{asset("img/logo.svg")}}" alt="Logo"></div><a class="home-page__top-sign-in btn btn--border" href="{{ route('login') }}">sign IN</a>
        </div>
        <div class="home-page__middle">
            <div class="col left">
                <div class="home-page__title-top">Looking FOR a</div>
                <h2 class="home-page__title">COFOUNDER?</h2><a class="btn btn--border" href="{{ route('register') }}">START HERE</a>
                <div class="home-page__descr-wrapper">
                    <div class="home-page__descr-title">time to move forward-fast</div>
                    <div class="home-page__descr">Being a founder can be a lonely business and hard work is seldom enough to guarantee success. BeMyCoFounder is a FREE platform to help match you with the experts your project needs.</div>
                </div>
            </div>
            <div class="col right">
                <div class="home-page__title-top">I want Became a</div>
                <h2 class="home-page__title">COFOUNDER!</h2><a class="btn btn--border" href="{{ route('register') }}">START HERE</a>
                <div class="home-page__descr-wrapper">
                    <div class="home-page__descr-title">True value of you</div>
                    <div class="home-page__descr">Realise the full value of your skills, market knowledge and experience with BeMyCoFounder. Free sign up will connect you with unique opportunities to team up with innovators and start-ups to do what you love and on your terms.</div>
                </div>
            </div>
        </div>
        <div class="home-page__bottom">
            <div class="home-page__bottom-links"><a href="#">privacy</a><a href="#">Terms & Conditions</a></div>
            <div class="copyright">(c) {{date('Y')}} BeMyCoFounder</div>
        </div>
    </div>
</main>

@endsection
