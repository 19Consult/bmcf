@extends('layouts.app')

@section('content')

    <main class="wrapper profile">
        @include("layouts.nav-menu-home", ['title_page' => $data['title_page']])
        <div class="dashboard-wrapper">
            @include("layouts.sidebar")
            <div class="dashboard__wrapper projects-wrapper">
                <form class="project__search-bar" method="GET" action="">
                    <div style="color: var(--color-first);">Selected for you</div>
                    <div class="project__search-field">
                        <input name="search_keyword" type="text" placeholder="Search by Keyword" value="{{$search_keyword}}">
                        <button class="search-btn" onchange="this.form.submit()"></button>
                    </div>
                    <select name="categories" class="categories select-list" onchange="this.form.submit()">
                        <option></option>
                        <option selected="true" value="">All Categories</option>
                        @if(!empty($data['category']))
                            @foreach($data['category'] as $key => $val)
                                <option value="{{$val->category_name}}" {{ $categories == $val->category_name ? 'selected' : '' }}>{{$val->category_name}}</option>
                            @endforeach
                        @endif
                    </select>
                    <a href="{{route("dashboardOwner")}}" class="btn--arrow btn--solid search-reset">Reset</a>

                </form>
                <div class="dashboard-begin">
                    <div class="dashboard-s1">
                        @if(!empty($data['projects']) && isset($data['projects']) && $data['projects']->toArray()['total'] > 0)
                            @foreach($data['projects'] as $key => $val)
                                <?php
                                $views = $val->views->first();
                                $ndaList = App\Models\NdaProjects::where('id_project', $val->id)->where('status', 'signed')->pluck('user_id')->toArray();
                                ?>
                                <div class="project__item">
                                    <div class="project__item-wrap">
                                        <div class="project__img"><img src="{{isset($val->photo_project) ? asset($val->photo_project) : 'img/project-img.webp'}}" alt="Project image"></div>
                                        <div class="project__content top">
                                            <div class="project__title-wrap">

                                                <a class="project__title_link" href="{{route("viewProject", ['id' => $val->id])}}">{{isset($val->name_project) ? $val->name_project : ''}}</a>

                                                <div class="project__subtitle">Social</div>
                                            </div>
                                            <div style="display: none" class="project__favorite favorite-projid-{{$val->id}} {{in_array($val->id, $data['favorite_project']) ? 'active' : ''}}" project-id="{{$val->id}}"></div>
                                        </div>
                                        <div class="project__content bottom">
                                            <div class="project__views">
                                                <div class="project__views-title">Project views</div>
                                                <div class="project__views-quantity pr-total_views-{{$val->id}}">{{!empty($views->total_views) ? $views->total_views : 0}}</div>
                                            </div>
                                            <div class="project__interested">
                                                <div class="project__interested-title">Angel Interested</div>
                                                <div class="project__interested-quantity">{{count($ndaList)}}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        @else
                            <div class="error-search-project">Sorry, nothing found</div>
                        @endif
                    </div>
                    <div class="dashboard-s2">
                        @if(!empty($data['nda_list']) && isset($data['nda_list']) && count($data['nda_list']->toArray()) > 0)
                            @foreach($data['nda_list'] as $key => $val)
                                <?php
                                $user = App\Models\User::where('id', $val->user_id)->first();
                                if(empty($user->detail)){
                                    continue;
                                }
                                $country = (new  App\Http\Controllers\CountryController)->getNameCountry($user->detail->country);

                                $sector = '';
                                if(!empty($user->detail->categorty1_investor)){
                                    $sector .= $user->detail->categorty1_investor . ', ';
                                }
                                if(!empty($user->detail->categorty2_investor)){
                                    $sector .= $user->detail->categorty2_investor . ', ';
                                }
                                if(!empty($user->detail->categorty3_investor)){
                                    $sector .= $user->detail->categorty3_investor;
                                }
                                ?>
                                <div class="project__item">
                                    <div class="project__item-wrap">
                                        <div class="project__img">
                                            <img src="{{isset($user->detail->photo) ? asset($user->detail->photo) : 'img/project-img.webp'}}" alt="User image"></div>
                                        <div class="project__content top">
                                            <div class="project__content-user-name">{{$user->detail->first_name}} {{$user->detail->last_name}}</div>
                                            <div class="project__content-user-sector">{{$sector}}</div>
                                            <div class="project__content-user-country">{{$country}}</div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        @else
                            <div class="error-search-project">Sorry, nothing found</div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </main>

@endsection
