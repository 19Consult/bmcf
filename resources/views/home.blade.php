@extends('layouts.app')

@section('content')

    <main class="wrapper projects">
        @include("layouts.nav-menu-home", ['title_page' => $data['title_page']])
        <div class="dashboard-wrapper">
            @include("layouts.sidebar")
            <div class="projects-wrapper">

                @if(!empty( $data['projects']) && isset( $data['projects']))
                    @foreach($data['projects'] as $key => $val)
                        <?php $views = $val->views->first();?>
                        <div class="project__item">
                            <div class="project__item-wrap">
                                <div class="project__img"><img src="{{isset($val->photo_project) ? asset($val->photo_project) : 'img/project-img.webp'}}" alt="Project image"></div>
                                <div class="project__content top">
                                    <div class="project__title-wrap">
                                        <div class="project__title">{{isset($val->name_project) ? $val->name_project : ''}}</div>
                                        <div class="project__subtitle">100%</div>
                                    </div>
                                    <a href="{{route("viewProject", ['id' => $val->id])}}" class="project__edit">Edit</a>
                                </div>
                                <div class="project__content bottom">
                                    <div class="project__views">
                                        <div class="project__views-title">Project views</div>
                                        <div class="project__views-quantity">
                                            {{!empty($views->total_views) ? $views->total_views : 0}}
                                            <span>{{!empty($views->today_views) ? '+' . $views->today_views : ''}}</span>
                                        </div>
                                    </div>
                                    <div class="project__nda">
                                        <div class="project__nda-title">NDA Signed</div>
                                        <div class="project__nda-user-wrap">
                                            <div class="project__nda-user"><img src="img/user.webp" alt="User"></div>
                                            <div class="project__nda-user"><img src="img/user-2.webp" alt="User"></div>
                                            <div class="project__nda-user"><img src="img/user-2.webp" alt="User"></div>
                                            <div class="project__nda-user"><img src="img/user-2.webp" alt="User"></div>
                                            <div class="project__nda-user"><img src="img/user-2.webp" alt="User"></div>
                                            <div class="project__nda-user"><img src="img/user-2.webp" alt="User"></div>
                                            <div class="project__nda-quantity"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif

                <div class="project__item project__add">
                    <div class="project__item-wrap">
                        <a href="{{route("createProject")}}">
                            <div class="project__add-btn"></div>
                            <div class="project__add-text">Add new Project</div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>

@endsection
