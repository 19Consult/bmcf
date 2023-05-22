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

                                @if(App\Models\User::checkOwner())
                                    <div class="profile__favorite {{$check_favorite_owner ? 'active' : ''}}" owner_id="{{auth()->id()}}" investor_id="{{$data['user']->user_id}}"></div>
                                @endif

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

        <style>
            .profile__favorite {
                margin-top: 4px;
                margin-right: 10px;
                width: 20px;
                height: 20px;
                background: url("../img/icons/icon-favorite.svg") no-repeat;
                background-position: center;
                background-size: contain;
                cursor: pointer;
                margin-left: auto;
            }
            .profile__favorite.active {
                background: url("../img/icons/icon-favorite-active.svg") no-repeat;
            }
        </style>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                $(document).ready(function () {

                    $('.profile__favorite').click(function() {

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        var owner_id = $(this).attr('owner_id');
                        var investor_id = $(this).attr('investor_id');


                        let data = {
                            owner_id: owner_id,
                            investor_id: investor_id,
                        };

                        //console.log(data);

                        $.ajax({
                            url: '{{route("profilePublicFavorite")}}',
                            method: 'POST',
                            data: data,
                            success: function(data) {
                                //console.log(data);
                                let favoriteClass = $(`.profile__favorite`);
                                if(data.success){
                                    favoriteClass.addClass("active")
                                }else {
                                    favoriteClass.removeClass("active")
                                }
                            },
                            error: function(xhr, textStatus, errorThrown) {
                                console.log(xhr.responseText); // replace with your own error callback function
                            }
                        });
                    });

                });
            });

        </script>
    @endif
@endsection
