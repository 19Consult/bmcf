@extends('layouts.app')

@section('content')

    <main class="wrapper home-page sign-in reset-pass">
        <div class="container">
            <div class="home-page__top">
                <div class="home-page__top-logo"><a href="{{route("welcome")}}"><img src="{{asset("img/logo.svg")}}" alt="Logo"></a></div>
            </div>
            <div class="home-page__middle-wrapper">
                <div class="home-page__middle">
                    <div class="col left">
                        <div class="home-page__title-top">Account</div>
                        <h2 class="home-page__title">{{ __('New Password') }}</h2>
                    </div>
                    <div class="col right">

                        <form method="POST" action="{{ route('password.update') }}" class="type-1">
                            @csrf

                            <input type="hidden" name="token" value="{{ $token }}">

                            <div class="row mb-3 form_input_wrap">
                                @error('email')
                                <span class="invalid-feedback error-message" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror

                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                                <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>
                            </div>

                            <div class="row mb-3 form_input_wrap">
                                @error('password')
                                <span class="invalid-feedback error-message" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror

                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('New Password') }}</label>
                            </div>

                            <div class="row mb-3 form_input_wrap">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm New Password') }}</label>
                            </div>

                            <div class="row mb-0 form_input_wrap">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary btn--solid btn--arrow">
                                        {{ __('Reset Password') }}
                                    </button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
