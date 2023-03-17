@extends('layouts.app')

@section('content')

    <main class="wrapper project-favorites">
        @include("layouts.nav-menu-home")
    <div class="dashboard-wrapper">
        @include("layouts.sidebar")
        <div class="projects-wrapper">
            <div class="project__item-favorite">

                @if(!empty($data['projects']))
                    @foreach($data['projects'] as $val)
                        <div class="project__item-favorite-wrap">
                            <div class="project__img"><img src="{{!empty($val->photo_project) ? asset($val->photo_project) : asset("img/icons/icon-add-photo.svg")}}" alt="Project image"></div>
                            <div class="project__content">
                                <div class="project__title-wrap">
                                    <div class="project__title">{{!empty($val->name_project) ? $val->name_project : ''}}</div>
                                    <div class="project__subtitle">{{!empty(Auth::user()->detail->first_name) ? Auth::user()->detail->first_name : ''}} {{!empty(Auth::user()->detail->last_name) ? Auth::user()->detail->last_name : ''}}</div>
                                </div>
                            </div>
                            <div class="project__type">
                                @if(!empty($val->keyword1))
                                    <span>{{$val->keyword1}}</span>
                                @endif
                                @if(!empty($val->keyword2))
                                    <span>{{$val->keyword2}}</span>
                                @endif
                                @if(!empty($val->keyword3))
                                    <span>{{$val->keyword3}}</span>
                                @endif
                            </div>
                            <div class="project__icon-favorite"></div>
                        </div>
                    @endforeach
                @endif

                <div class="project__item-favorite-wrap">
                    <div class="project__img"><img src="img/project-img.webp" alt="Project image"></div>
                    <div class="project__content">
                        <div class="project__title-wrap">
                            <div class="project__title">The Athletic Buro</div>
                            <div class="project__subtitle">Mark Jacob</div>
                        </div>
                    </div>
                    <div class="project__type">
                        <span>Sport</span>
                        <span>Social</span>
                    </div>
                    <div class="project__icon-favorite"></div>
                </div>
                <div class="project__item-favorite-wrap">
                    <div class="project__img"><img src="img/project-img.webp" alt="Project image"></div>
                    <div class="project__content">
                        <div class="project__title-wrap">
                            <div class="project__title">The Athletic Buro</div>
                            <div class="project__subtitle">Derec Roze</div>
                        </div>
                    </div>
                    <div class="project__type"><span>Finance</span></div>
                    <div class="project__icon-favorite"></div>
                </div>


            </div>
        </div>
    </div>
</main>

@endsection
