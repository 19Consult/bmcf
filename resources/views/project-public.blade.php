@extends('layouts.app')

@section('content')
    <main class="wrapper project-create">
        <div class="dashboard-wrapper">
            <div class="project-create-wrap">
                <div class="project-create-wrap-img"><img src="{{asset("img/create-project-bg.webp")}}" alt="Project background"></div>
                <div class="project-create__content-wrap">
                    <div class="project-create__top">
                        <div class="project-create__top-img has-img"><img src="{{!empty($data['project']->photo_project) ? asset($data['project']->photo_project) : asset("img/icons/icon-add-photo.svg")}}" alt="Add photo"></div>
                        <div class="project-create__top-descr">
                            <div class="project-create__top-descr-top">
                                <div class="project-create__top-descr-top-title">{{!empty($data['project']->name_project) ? substr($data['project']->name_project, 0, strlen($data['project']->name_project) / 2).'...' : ''}}<span></span></div>
                                <div class="project-create__top-descr-top-type">
                                </div>
                            </div>
                            <div class="field-text">
                                @if(!empty($data['project']->brief_description))
                                    <p>{{substr($data['project']->brief_description, 0, strlen($data['project']->brief_description) / 2)}}...</p>
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
                                <a href="{{route('viewProjectPublicNext', ['id' => $data['project']->id])}}" class="project-create__top-right-send btn--solid btn--arrow  btn">Login</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
