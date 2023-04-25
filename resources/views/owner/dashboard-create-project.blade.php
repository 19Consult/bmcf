@extends('layouts.app')

@section('content')

    <?php
    $done_registration = true;
    $done_tell_about_you = false;
    $done_short_description = false;
    $done_add_pictures = false;
    $done_tell_your_story = false;
    $done_business_plan = false;
    $done_add_video_teaser = false;
    $done_co_founder_conditions = false;
    $done_found_co_founder = false;

    if(!empty($data['about_you'])){
        $done_tell_about_you = true;
    }
    if(!empty($data['project']->brief_description)){
        $done_short_description = true;
    }
    if(!empty($data['project']->photo_project)){
        $done_add_pictures = true;
    }
    if(!empty($data['project']->project_story)){
        $done_tell_your_story = true;
    }
    if(!empty($data['project']->business_plan)){
        $done_business_plan = true;
    }
    if(!empty($data['project']->youtube_link) || !empty($data['project']->vimeo_link)){
        $done_add_video_teaser = true;
    }
    if(!empty($data['project']->co_founder_terms_condition)){
        $done_co_founder_conditions = true;
    }
    if(false){
        $done_found_co_founder = true;
    }

    $check_current = true;
    ?>

    <style>
        .rj-short-description{
            left: 27.4%;
        }
        .rj-add-pictures{
            left: 38.4%;
        }
        .rj-tell-your-story{
            left: 49.4%;
        }
        .rj-business-plan{
            left: 60.4%;
        }
        .rj-add-video-teaser{
            left: 71.4%;
        }
        .rj-co-founder-conditions{
            left: 82.9%;
        }
        .rj-found-co-founder{
            left: 93.9%;
        }

        .rjl-short-description::after{
            width: 27.3%;
        }
        .rjl-add-pictures::after{
            width: 38.4%;
        }
        .rjl-tell-your-story::after{
            width: 49.5%;
        }
        .rjl-business-plan::after{
            width: 60.6%;
        }
        .rjl-add-video-teaser::after{
            width: 71.6%;
        }
        .rjl-co-founder-conditions::after{
            width: 82.85%;
        }
        .rjl-found-co-founder::after{
            width: 93.93%;
        }
    </style>

    <?php
    $chech_line = true;
    $number_line = 2;
    $chech_line_class = '';
    $middle_line = '';
    $present_process = 0;
    if(!$done_tell_about_you && $chech_line){
        $chech_line = false;

    }elseif(!$done_short_description && $chech_line){
        $chech_line_class = 'rj-short-description';
        $chech_line = false;
        $number_line = 3;
        $middle_line = 'rjl-short-description';
        //$present_process += 15;
    }elseif (!$done_add_pictures && $chech_line){
        $chech_line_class = 'rj-add-pictures';
        $chech_line = false;
        $number_line = 4;
        $middle_line = 'rjl-add-pictures';
        //$present_process += 15;
    }elseif (!$done_tell_your_story && $chech_line){
        $chech_line_class = 'rj-tell-your-story';
        $chech_line = false;
        $number_line = 5;
        $middle_line = 'rjl-tell-your-story';
        //$present_process += 15;
    }elseif (!$done_business_plan && $chech_line){
        $chech_line_class = 'rj-business-plan';
        $chech_line = false;
        $number_line = 6;
        $middle_line = 'rjl-business-plan';
        //$present_process += 15;
    }elseif (!$done_add_video_teaser && $chech_line){
        $chech_line_class = 'rj-add-video-teaser';
        $chech_line = false;
        $number_line = 7;
        $middle_line = 'rjl-add-video-teaser';
        //$present_process += 15;
    }elseif (!$done_co_founder_conditions && $chech_line){
        $chech_line_class = 'rj-co-founder-conditions';
        $chech_line = false;
        $number_line = 8;
        $middle_line = 'rjl-co-founder-conditions';
        //$present_process += 9;
    }elseif (!$done_found_co_founder && $chech_line){
        $chech_line_class = 'rj-found-co-founder';
        $chech_line = false;
        $number_line = 9;
        $middle_line = 'rjl-found-co-founder';
        //$present_process += 1;
    }


    if(!$done_tell_about_you ){
        $chech_line = false;
    }
    if($done_tell_about_you ){
        $present_process += 15;
    }
    if($done_short_description ){
        $middle_line = 'rjl-short-description';
        $present_process += 15;
    }
    if ($done_add_pictures){
        $middle_line = 'rjl-add-pictures';
        $present_process += 15;
    }
    if ($done_tell_your_story){
        $middle_line = 'rjl-tell-your-story';
        $present_process += 15;
    }
    if ($done_business_plan){
        $middle_line = 'rjl-business-plan';
        $present_process += 15;
    }
    if ($done_add_video_teaser){
        $middle_line = 'rjl-add-video-teaser';
        $present_process += 15;
    }
    if ($done_co_founder_conditions){
        $middle_line = 'rjl-co-founder-conditions';
        $present_process += 9;
    }
    if ($done_found_co_founder){
        $middle_line = 'rjl-found-co-founder';
        $present_process += 1;
    }

    ?>



<main class="wrapper project-create">
    @include("layouts.nav-menu", ['title_page' => $data['title_page']])
    <div class="dashboard-wrapper">
        @include("layouts.sidebar")
        <div class="project-create-wrap">
            <div class="project-create-wrap-img"><img src="{{asset("img/create-project-bg.webp")}}" alt="Project background"></div>
            <form class="project-create__content-wrap" action="{{route("saveProject")}}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id_project" value="{{!empty($id_project) ? $id_project : 0}}">
                <div class="project-create__top">
{{--                    <div class="project-create__top-img"><img src="img/icons/icon-add-photo.svg" alt="Add photo"></div>--}}
                    <label class="project-create__top-img {{!empty($data['project']->photo_project) ? 'show' : ''}} " id="proj-img">
                        <img src="{{!empty($data['project']->photo_project) ? asset($data['project']->photo_project) : asset("img/icons/icon-add-photo.svg")}}" alt="Add photo">
                        <input name="photo_project" type="file" id="proj-img-uploader" style="display:none">
                    </label>

                    <div class="project-create__top-descr">
                        <div class="project-create__top-descr-top">
                            <div class="project-create__top-descr-top-title name-project-title">
                                <input type="text" id="name_project" placeholder="Name project" name="name_project" value="{{!empty($data['project']->name_project) ? $data['project']->name_project : ''}}">
                                <span class="present-process">{{$present_process}}%</span>
                                <input type="hidden" name="present_process" class="present-process-input" value="{{$present_process}}">
                            </div>
                            <div class="project-create__top-descr-top-type add-keyword">
                                @if(!empty($data['project']->keyword1))
                                    <span>{{$data['project']->keyword1}}</span>
                                @endif
                                @if(!empty($data['project']->keyword2))
                                    <span>{{$data['project']->keyword2}}</span>
                                @endif
                                @if(!empty($data['project']->keyword3))
                                    <span>{{$data['project']->keyword3}}</span>
                                @endif
                            </div>
                        </div>
                        <div class="field-add brief_description_project scrollbar-inner scrollbar-init">
                            @if(!empty($data['project']->brief_description))
                                {{$data['project']->brief_description}}
                            @else
                                <div class="field-add-btn"></div>
                                <div class="field-add-text">Add Brief Project Desription</div>
                            @endif
                        </div>
                        <div class="field-text__edit">Edit</div>
                        <div class="project-create__top--popup popup">
                            <div class="popup__wrap">
                                <div class="popup__content">
                                    <div class="popup__nav">
                                        <div class="popup__nav-back"><a href="#">Go Back</a><span>Brief Description</span></div>
                                    </div>
                                    <div class="project-preview__content">
                                        <div class="row descr">
                                            <div class="col fields">
                                                <div class="row row-field">
                                                    <div class="form_input_wrap full-width">
                                                        <textarea name="brief_description_project" type="text" placeholder="Type" rows="10" maxlength="3400">{{!empty($data['project']->brief_description) ? $data['project']->brief_description : ''}}</textarea>
                                                        <label class="schetchik-brief-desc">(0/3400)</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row keyword">
                                            <div class="col fields">
                                                <div class="col row-field">
                                                    <div class="form_input_wrap">

                                                        {{--<input type="text" placeholder="Key Word" name="keyword1" value="{{!empty($data['project']->keyword1) ? $data['project']->keyword1 : ''}}">--}}

                                                        <select class="keyword-list" name="keyword1">
                                                            <option></option>
                                                            <option selected="true" disabled="disabled">All Categories</option>
                                                            @if(!empty($data['category']))
                                                                @foreach($data['category'] as $key => $val)
                                                                    <option value="{{$val->category_name}}" {{ !empty($data['project']->keyword1) && $data['project']->keyword1 == $val->category_name ? 'selected' : '' }}>{{$val->category_name}}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>

                                                        <label for="salutation">Key words (up to 3)</label>
                                                    </div>
                                                    <div class="form_input_wrap">
                                                        {{--<input type="text" placeholder="Key Word" name="keyword2" value="{{!empty($data['project']->keyword2) ? $data['project']->keyword2 : ''}}">--}}

                                                        <select class="keyword-list" name="keyword2">
                                                            <option></option>
                                                            <option selected="true" disabled="disabled">All Categories</option>
                                                            @if(!empty($data['category']))
                                                                @foreach($data['category'] as $key => $val)
                                                                    <option value="{{$val->category_name}}" {{ !empty($data['project']->keyword2) && $data['project']->keyword2 == $val->category_name ? 'selected' : '' }}>{{$val->category_name}}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>

                                                    </div>
                                                    <div class="form_input_wrap">
                                                        {{--<input type="text" placeholder="Key Word" name="keyword3" value="{{!empty($data['project']->keyword3) ? $data['project']->keyword3 : ''}}">--}}

                                                        <select class="keyword-list" name="keyword3">
                                                            <option></option>
                                                            <option selected="true" disabled="disabled">All Categories</option>
                                                            @if(!empty($data['category']))
                                                                @foreach($data['category'] as $key => $val)
                                                                    <option value="{{$val->category_name}}" {{ !empty($data['project']->keyword3) && $data['project']->keyword3 == $val->category_name ? 'selected' : '' }}>{{$val->category_name}}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>

                                                    </div>
                                                </div>
                                            </div>
                                        </div><a class="btn--arrow btn--solid btn btn-ajax-first-section" >Submit</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>




                    <script>
                        document.addEventListener('DOMContentLoaded', function () {

                            $(document).ready(function() {
                                //keyword-list
                                $('.keyword-list').select2();

                                function isEmptyOrSpaces(str){
                                    return str === null || str.match(/^ *$/) !== null;
                                }

                                $('textarea[name="brief_description_project"]').on("input", function() {
                                    const maxlength = 3400;
                                    const currentLength = $(this).val().length;
                                    $('.schetchik-brief-desc').html(`(${currentLength}/${maxlength})`);
                                });


                                $('.btn-ajax-first-section').on('click', function(event) {
                                    event.preventDefault();

                                    var brief_description_project = $('textarea[name="brief_description_project"]').val();
                                    var keyword1 = $('select[name="keyword1"]').val();
                                    var keyword2 = $('select[name="keyword2"]').val();
                                    var keyword3 = $('select[name="keyword3"]').val();

                                    $(".add-keyword").html('');

                                    if(!isEmptyOrSpaces(keyword1)){
                                        $(".add-keyword").append('<span>' + keyword1 + '</span>');
                                    }
                                    if(!isEmptyOrSpaces(keyword2)){
                                        $(".add-keyword").append('<span>' + keyword2 + '</span>');
                                    }
                                    if(!isEmptyOrSpaces(keyword3)){
                                        $(".add-keyword").append('<span>' + keyword3 + '</span>');
                                    }

                                    // brief_description_project
                                    let start_brief_description_project = `<div class="field-add-btn"></div>
                                        <div class="field-add-text">Add Brief Project Desription</div>`;

                                    if(!isEmptyOrSpaces(brief_description_project)){
                                        $(".brief_description_project").html(brief_description_project);
                                        $(".brief_description_project").addClass("add-description add-content");
                                        $(".brief_description_project.add-content").next(".field-text__edit").show()
                                    }else {
                                        $(".brief_description_project").html(start_brief_description_project);
                                        $(".brief_description_project").removeClass("add-description add-content");
                                        $(".brief_description_project").next(".field-text__edit").hide()
                                    }

                                    //close popup
                                    $(".project-create__top--popup.popup").removeClass("open");

                                });

                                $('.btn-content-project-story').on('click', function(event) {
                                    event.preventDefault();

                                    var content_project_story = CKEDITOR.instances["content_project_story"];

                                    var editorValue = content_project_story.getData();

                                    let start_project_story = `<div class="field-add-btn"></div>
                                        <div class="field-add-text">Tell Your Story</div>`;

                                    if(!isEmptyOrSpaces(editorValue)){
                                        $(".field_project_story").html(editorValue);
                                        $(".field_project_story").addClass("add-project-story add-content");
                                        $(".field_project_story.add-content").next(".field-text__edit").show()
                                    }else {
                                        $(".field_project_story").html(start_project_story);
                                        $(".field_project_story").removeClass("add-project-story add-content");
                                        $(".field_project_story").next(".field-text__edit").hide()
                                    }

                                    //close popup
                                    $(".popup.project-story").removeClass("open");

                                });



                                $('.btn-business-plan').on('click', function(event) {
                                    event.preventDefault();

                                    var content_project_story = CKEDITOR.instances["content_business_plan"];

                                    var editorValue = content_project_story.getData();

                                    let start = `<div class="field-add-btn"></div>
                                        <div class="field-add-text">Describe Your Business Plan</div>`;

                                    if(!isEmptyOrSpaces(editorValue)){
                                        $(".field-business-plan").html(editorValue);
                                        $(".field-business-plan").addClass("add-business-plan add-content");
                                        $(".field-business-plan.add-content").next(".field-text__edit").show()
                                    }else {
                                        $(".field-business-plan").html(start);
                                        $(".field-business-plan").removeClass("add-business-plan add-content");
                                        $(".field-business-plan").next(".field-text__edit").hide()
                                    }

                                    //close popup
                                    $(".popup.business-plan").removeClass("open");

                                });

                                $('.btn-co-founder-terms-condition').on('click', function(event) {
                                    event.preventDefault();

                                    var content_project_story = CKEDITOR.instances["co_founder_terms_condition"];

                                    var editorValue = content_project_story.getData();

                                    let start = `<div class="field-add-btn"></div>
                                        <div class="field-add-text">Describe Your Business Plan</div>`;

                                    if(!isEmptyOrSpaces(editorValue)){
                                        $(".field-co-founder-terms-condition").html(editorValue);
                                        $(".field-co-founder-terms-condition").addClass("add-co-founder-terms-condition add-content");
                                        $(".field-co-founder-terms-condition.add-content").next(".field-text__edit").show()
                                    }else {
                                        $(".field-co-founder-terms-condition").html(start);
                                        $(".field-co-founder-terms-condition").removeClass("add-co-founder-terms-condition add-content");
                                        $(".field-co-founder-terms-condition").next(".field-text__edit").hide()
                                    }

                                    //close popup
                                    $(".popup.co-founder-terms-condition").removeClass("open");

                                });

                                // if field has content
                                $('.field-add p').parents('.field-add').addClass('add-content')
                                $('.field-add img').parents('.field-add').addClass('add-content')

                                if($('.brief_description_project').children().length === 0) {
                                    $('.brief_description_project').addClass('add-description add-content')
                                }


                                const projPhotoBtn = document.getElementById('proj-img-uploader');
                                const projReader = new FileReader();
                                const projPhoto = document.getElementById('proj-img');

                                if (projPhotoBtn) {
                                    projPhotoBtn.addEventListener('change', (event) => {
                                        console.log('test')
                                        projPhoto.classList.add('show')
                                        const files = event.target.files;
                                        const file = files[0];
                                        projReader.readAsDataURL(file);

                                        projReader.addEventListener('load', (event) => {
                                            const img = document.createElement('img');
                                            projPhoto.querySelector('img').remove();
                                            projPhoto.appendChild(img);
                                            img.src = event.target.result;
                                            img.alt = file.name;
                                        });
                                    });
                                }

                            });

                        });


                        // let registration = 0;
                        // let tellAboutYou = 0;
                        // let shortDescription = 0;
                        // let addPictures = 0;
                        // let tellYourStory = 0;
                        // let businessPlan = 0;
                        // let addVideoTeaser = 0;
                        // let coFounderConditions = 0;
                        // let foundCoFounder = 0;
                        //
                        // const registrationInput = document.getElementById('registration-input');
                        // registrationInput.addEventListener('input', () => {
                        //     registration = 1;
                        //     updateCompletionPercentage();
                        // });
                        //
                        // function updateCompletionPercentage() {
                        //     const totalSteps = 9;
                        //     const completedSteps = registration + tellAboutYou + shortDescription + addPictures + tellYourStory + businessPlan + addVideoTeaser + coFounderConditions + foundCoFounder;
                        //     const completionPercentage = Math.round((completedSteps / totalSteps) * 100);
                        //     const completionBar = document.getElementById('completion-bar');
                        //     completionBar.style.width = completionPercentage + '%';
                        //     completionBar.innerText = completionPercentage + '% Complete';
                        // }

                    </script>

                    <div class="project-create__top-right">
                        <div class="project-create__top-right-top">
                            <div class="project-preview__author">
                                <div class="project-preview__author-img"><img src="{{asset($data['user_photo'])}}" alt="User"></div>
                                <div class="project-preview__author-title">
                                    <div class="project-preview__author-name">
                                        {{!empty($data['first_name']) ? $data['first_name'] : ''}}
                                        {{!empty($data['last_name']) ? $data['last_name'] : ''}}
                                    </div>
                                    <div class="project-preview__author-position">Idea Owner</div>
                                </div>
                                <a href="{{route("profile")}}" class="project-preview__author-settings" target="_blank"></a>
                            </div>
                            <div class="project-create__top-right-send btn--solid btn--arrow btn" onclick="saveBtn()">Submit</div>
                        </div>
                        <?php
                        if(!empty($data['project']->views)){
                            $views = $data['project']->views->first();
                        }
                        ?>
                        <div class="project-create__top-right-bottom">Project views<span>{{!empty($views->total_views) ? $views->total_views : 0}}</span></div>
                    </div>
                </div>

                <div class="project-create__progress-line progress {{$middle_line}}">
                    <div class="progress__item-bottom {{$chech_line_class}}">
                        <div class="progress__item-bottom-prev"></div>
                        <div class="progress__item-bottom-quantity"><span class="rj-number-line">{{$number_line}}</span><span>/</span><span>9</span></div>
                        <div class="progress__item-bottom-next"></div>
                    </div>
                    <div class="progress__item done">
                        <div class="progress__item-top">Registration</div>
                        <div class="progress__item-point"></div>
                    </div>
                    <div class="progress__item {{$done_tell_about_you ? 'done': (($check_current) ? 'current' . ($check_current=false)  : '') }}">
                        <div class="progress__item-top">Tell About You</div>
                        <div class="progress__item-point"></div>
                    </div>
                    <div class="progress__item {{$done_short_description ? 'done': (($check_current) ? 'current' . ($check_current=false)  : '') }}">
                        <div class="progress__item-top">Short Description</div>
                        <div class="progress__item-point"></div>
                    </div>
                    <div class="progress__item {{$done_add_pictures ? 'done': (($check_current) ? 'current' . ($check_current=false)  : '') }}">
                        <div class="progress__item-top">Add Pictures</div>
                        <div class="progress__item-point"></div>
                    </div>
                    <div class="progress__item {{$done_tell_your_story ? 'done': (($check_current) ? 'current' . ($check_current=false)  : '') }}">
                        <div class="progress__item-top">Tell Your Story</div>
                        <div class="progress__item-point"></div>
                    </div>
                    <div class="progress__item {{$done_business_plan ? 'done': (($check_current) ? 'current' . ($check_current=false)  : '') }}">
                        <div class="progress__item-top">Business Plan</div>
                        <div class="progress__item-point"></div>
                    </div>
                    <div class="progress__item {{$done_add_video_teaser ? 'done': (($check_current) ? 'current' . ($check_current=false)  : '') }}">
                        <div class="progress__item-top">Add Video Teaser</div>
                        <div class="progress__item-point"></div>
                    </div>
                    <div class="progress__item {{$done_co_founder_conditions ? 'done': (($check_current) ? 'current' . ($check_current=false)  : '') }}">
                        <div class="progress__item-top">CoFounder Conditions</div>
                        <div class="progress__item-point"></div>
                    </div>
                    <div class="progress__item {{$done_found_co_founder ? 'done': (($check_current) ? 'current' . ($check_current=false)  : '') }}">
                        <div class="progress__item-top">Found CoFounder</div>
                        <div class="progress__item-point"></div>
                    </div>
                </div>
                <div class="form-profile project-form" >
                    <div class="row project-field">
                        <div class="col title">Project Story <span>*</span></div>
                        <div class="col fields">
                            <div class="col row-field">
                                <div class="form_input_wrap">
                                    <div class="field-add field_project_story">

                                        @if(!empty($data['project']->project_story))
                                            {!! $data['project']->project_story !!}
                                        @else
                                            <div class="field-add-btn"></div>
                                            <div class="field-add-text">Tell Your Story</div>
                                        @endif
                                    </div>
                                    <div class="field-text__edit">Edit</div>
                                </div>
                                <div class="popup project-story">
                                    <div class="popup__wrap">
                                        <div class="popup__content">
                                            <div class="popup__nav">
                                                <div class="popup__nav-back"><a href="#">Go Back</a><span>Project Story</span></div>
                                            </div>
                                            <div class="popup__content-wrap">
                                                <textarea id="content_project_story" name="content_project_story" class="ckeditor">{{!empty($data['project']->project_story) ? $data['project']->project_story : ''}}</textarea>
                                                <a class="btn--arrow btn--solid btn send btn-content-project-story" href="#">Submit</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row project-video">
                        <div class="col title">Add Video Teaser
                            <div class="form_input_wrap">
                                <input id="skip-video" type="checkbox" name="video_skip" value="1" {{(isset($data['project']->video_skip) && $data['project']->video_skip)? 'checked' : ''}}>
                                <label for="skip-video">Skip this</label>
                            </div>
                        </div>
                        <div class="col fields">
                            <div class="col row-field">
                                <div class="form_input_wrap">
                                    <input type="text" id="video-link-1" placeholder="http://" name="youtube_link" value="{{!empty($data['project']->youtube_link) ? $data['project']->youtube_link : ''}}">
                                    <label for="video-link-1">Yotube Link</label>
                                </div>
                                <div class="form_input_wrap">
                                    <input type="text" id="video-link-2" placeholder="http://" name="vimeo_link" value="{{!empty($data['project']->vimeo_link) ? $data['project']->vimeo_link : ''}}">
                                    <label for="video-link-2">Vimeo Link</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row project-plan">
                        <div class="col title">Business Plan
                            <div class="form_input_wrap">
                                <input id="skip-plan" type="checkbox" name="business_plan_skip" value="1" {{(isset($data['project']->business_plan_skip) && $data['project']->business_plan_skip)? 'checked' : ''}}>
                                <label for="skip-plan">Skip this</label>
                            </div>
                        </div>
                        <div class="col fields">
                            <div class="col row-field">
                                <div class="form_input_wrap">
                                    <div class="field-add field-business-plan">

                                        @if(!empty($data['project']->business_plan))
                                            {!! $data['project']->business_plan !!}
                                        @else
                                            <div class="field-add-btn"></div>
                                            <div class="field-add-text">Describe Your Business Plan</div>
                                        @endif
                                    </div>
                                    <div class="field-text__edit">Edit</div>
                                </div>
                                <div class="popup business-plan">
                                    <div class="popup__wrap">
                                        <div class="popup__content">
                                            <div class="popup__nav">
                                                <div class="popup__nav-back"><a href="#">Go Back</a><span>Business Plan</span></div>
                                            </div>
                                            <div class="popup__content-wrap">
                                                <textarea id="content_business_plan" name="content_business_plan" class="ckeditor">{{!empty($data['project']->business_plan) ? $data['project']->business_plan : ''}}</textarea>
                                                <a class="btn--arrow btn--solid btn send btn-business-plan" href="#">Submit</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row project-co-founder">
                        <div class="col title">CoFounder Terms & Conditions <span>*</span></div>
                        <div class="col fields">
                            <div class="col row-field">
                                <div class="form_input_wrap">
                                    <div class="field-add field-co-founder-terms-condition">

                                        @if(!empty($data['project']->co_founder_terms_condition))
                                            {!! $data['project']->co_founder_terms_condition !!}
                                        @else
                                            <div class="field-add-btn"></div>
                                            <div class="field-add-text">Describe the co-founders you are looking for what you are offering</div>
                                        @endif
                                    </div>
                                    <div class="field-text__edit">Edit</div>
                                </div>
                                <div class="popup co-founder-terms-condition">
                                    <div class="popup__wrap">
                                        <div class="popup__content">
                                            <div class="popup__nav">
                                                <div class="popup__nav-back"><a href="#">Go Back</a><span>Cofunder Terms</span></div>
                                            </div>
                                            <div class="popup__content-wrap">
                                                <textarea id="co_founder_terms_condition" name="co_founder_terms_condition" class="ckeditor">{{!empty($data['project']->co_founder_terms_condition) ? $data['project']->co_founder_terms_condition : ''}}</textarea>
                                                <a class="btn--arrow btn--solid btn send btn-co-founder-terms-condition" href="#">Submit</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="btn-owner-edit-project">
                        @if(!empty($id_project))
                            <a href="{{route("deleteProjectPreview", ['id_project' => $id_project])}}" class="btn btn--solid btn--arrow delete-account send">Delete project</a>
                        @endif
                        <button type="submit" class="btn btn--solid btn--arrow send send-form">Submit</button>
                    </div>

                </div>
            </form>
        </div>
    </div>
</main>
<script src="{{asset("js/form.js")}}"> </script>
@endsection
