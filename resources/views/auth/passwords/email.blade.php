@extends('layouts.app')

@section('content')

    <main class="wrapper home-page sign-in">
    <div class="container">
        <div class="home-page__top">
            <div class="home-page__top-logo"><a href="{{route("welcome")}}"><img src="{{asset("img/logo.svg")}}" alt="Logo"></a></div>
        </div>
        <div class="home-page__middle-wrapper">
            <div class="home-page__middle">
                <div class="col left">
                    <div class="home-page__title-top">Account</div>
                    <h2 class="home-page__title">Reset Password</h2>
                </div>
                <div class="col right">



                    <form class="type-1" method="POST" action="{{ route('password.email') }}">
                        @csrf

                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
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

                        <button class="btn btn--solid btn--arrow">Send Recovery Link</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

