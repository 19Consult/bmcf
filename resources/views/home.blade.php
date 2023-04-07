@extends('layouts.app')

@section('content')

    <main class="wrapper projects">
        @include("layouts.nav-menu-home", ['title_page' => $data['title_page']])
        <div class="dashboard-wrapper">
            @include("layouts.sidebar")
            <div class="projects-wrapper">

                @if(!empty( $data['projects']) && isset( $data['projects']))
                    @foreach($data['projects'] as $key => $val)
                        <?php
                        $present_process = 15;
                        if(!empty($val->about_you)){
                            $present_process += 15;
                        }
                        if(!empty($val->brief_description)){
                            $present_process += 15;
                        }
                        if(!empty($val->photo_project)){
                            $present_process += 15;
                        }
                        if(!empty($val->project_story)){
                            $present_process += 15;
                        }
                        if(!empty($val->business_plan)){
                            $present_process += 15;
                        }
                        if(!empty($val->youtube_link) || !empty($val->vimeo_link)){
                            $present_process += 15;
                        }
                        if(!empty($val->co_founder_terms_condition)){
                            $present_process += 9;
                        }

                        $views = $val->views->first();
                        ?>
                        <div class="project__item">
                            <div class="project__item-wrap">
                                <div class="project__img"><img src="{{isset($val->photo_project) ? asset($val->photo_project) : 'img/project-img.webp'}}" alt="Project image"></div>
                                <div class="project__content top">
                                    <div class="project__title-wrap">
                                        <div class="project__title">{{isset($val->name_project) ? $val->name_project : ''}}</div>
                                        <div class="project__subtitle">{{$present_process}}%</div>
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
                                    @php
                                        $nda_single_list_photo = false;
                                        $ndaList = App\Models\NdaProjects::where('id_project', $val->id)->where('status', 'signed')->pluck('user_id')->toArray();
                                        if(!empty($ndaList) && isset($ndaList)){
                                            $nda_single_list_photo = App\Models\UserDetail::whereIn('user_id', $ndaList)->pluck('photo');
                                        }
                                    @endphp
                                    <div class="project__nda">
                                        <div class="project__nda-title">NDA Signed</div>
                                        <div class="project__nda-user-wrap">
                                            @if($nda_single_list_photo)
                                                @foreach($nda_single_list_photo as $r)
                                                    <div class="project__nda-user"><img src="{{$r}}" alt="User"></div>
                                                @endforeach
                                                    <div class="project__nda-quantity"></div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif

                @if( App\Models\Projects::countProjects() < App\Models\Projects::getCountAssetProjects() )
                    <div class="project__item project__add">
                        <div class="project__item-wrap">
                            <a href="{{route("createProject")}}">
                                <div class="project__add-btn"></div>
                                <div class="project__add-text">Add new Project</div>
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </main>

@endsection
