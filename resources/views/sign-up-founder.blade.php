@extends('layouts.app')

@section('content')

    <main class="wrapper home-page sign-in sign-up-founder">
        <div class="container">
            <div class="home-page__top">
                <div class="home-page__top-logo"><a href="{{route("welcome")}}"><img src="img/logo.svg" alt="Logo"></a></div><a class="home-page__top-sign-in btn btn--border" href="#">sign IN</a>
            </div>
            <div class="home-page__middle-wrapper">
                <div class="home-page__middle">
                    <div class="col left">
                        <div class="home-page__title-top">Create A FOUNDER account</div>
                        <h2 class="home-page__title">Sign Up</h2>
                    </div>
                    <div class="col right">
                        <form class="type-1">
                            <div class="form_input_wrap">
                                <input type="mail" id="email" placeholder="Your Email">
                                <label for="email">Email</label>
                            </div>
                            <div class="form_input_wrap password">
                                <input type="password" id="password" placeholder="Your Password">
                                <label for="password">Password</label>
                                <input class="show-password" type="checkbox">
                            </div>
                            <div class="form_input_wrap password">
                                <input type="password" id="password" placeholder="Your Password">
                                <label for="password">Repeat password</label>
                                <input class="show-password" type="checkbox">
                            </div>
                            <button class="btn btn--solid btn--arrow">Register</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

@endsection
