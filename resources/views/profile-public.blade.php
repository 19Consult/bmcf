@extends('layouts.app')

@php
/*$check_type = false;
if(\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::id() != $user_id){
    $check_type = true;

}*/
@endphp

@section('content')
    @if(!$check_type)
        <main class="wrapper project-create">
            <div class="dashboard-wrapper">
                <div class="project-create-wrap">
                    <div class="project-create-wrap-img"><img src="{{asset("img/create-project-bg.webp")}}" alt="Project background"></div>
                    <div class="project-create__content-wrap">
                        <div class="project-create__top">
                            <div class="project-create__top-img has-img"><img src="{{!empty($data['user']->photo) ? asset($data['user']->photo) : asset("img/icons/icon-add-photo.svg")}}" alt="Add photo"></div>
                            <div class="project-create__top-descr">
                                <div class="project-create__top-descr-top">
                                    @php
                                    $full_name = $data['user']->first_name . ' ' . $data['user']->last_name;
                                    @endphp
                                    <div class="project-create__top-descr-top-title">{{!empty($full_name) ? substr($full_name, 0, strlen($full_name) / 2).'...' : ''}}<span></span></div>
                                    <div class="project-create__top-descr-top-type">
                                    </div>
                                </div>
                                <div class="field-text">
                                    @if(!empty($data['user']->about_you))
                                        <p>{{substr($data['user']->about_you, 0, strlen($data['user']->about_you) / 2)}}...</p>
                                    @endif
                                </div>
                            </div>
                            <div class="project-create__top-right">
                                <div class="project-create__top-right-top">
                                    <div class="project-preview__author">
                                        <div class="project-preview__author-img">
                                        </div>
                                        <div class="project-preview__author-title">
                                        </div>
                                    </div>
                                    <a href="{{route('viewProfilePublicNext', ['id' => $user_id])}}" class="project-create__top-right-send btn--solid btn--arrow  btn">Login</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    @else
        <main class="wrapper project-create">
            @include("layouts.nav-menu-home")
            <div class="dashboard-wrapper">
                @include("layouts.sidebar")
                <div class="project-create-wrap">
                    <div class="project-create-wrap-img"><img src="{{asset("img/create-project-bg.webp")}}" alt="Project background"></div>
                    <div class="project-create__content-wrap">
                        <div class="project-create__top">
                            <div class="project-create__top-img has-img"><img src="{{!empty($data['user']->photo) ? asset($data['user']->photo) : asset("img/icons/icon-add-photo.svg")}}" alt="Add photo"></div>
                            <div class="project-create__top-descr">
                                <div class="project-create__top-descr-top">
                                    @php
                                        $full_name = $data['user']->first_name . ' ' . $data['user']->last_name;
                                    @endphp
                                    <div class="project-create__top-descr-top-title">{{!empty($full_name) ? $full_name : ''}}<span></span></div>
                                    <div class="project-create__top-descr-top-type">
                                    </div>
                                </div>
                                <div class="field-text">
                                    @if(!empty($data['user']->about_you))
                                        <p>{{$data['user']->about_you}}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="project-create__top-right">
                                <div class="project-create__top-right-top">
                                    <div class="project-preview__author">
                                        <div class="project-preview__author-img">
                                        </div>
                                        <div class="project-preview__author-title">
                                        </div>
                                    </div>
                                    @if($check_nda)
                                        <a href="{{route('user', ['id' => $user_id])}}" class="project-create__top-right-send btn--solid btn--arrow btn--contact btn">Contact User</a>
                                    @else
{{--                                        <a href="{{route('viewProfilePublicNext', ['id' => $user_id])}}" class="project-create__top-right-send btn--solid btn--arrow  btn">Login</a>--}}
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    @endif
@endsection
