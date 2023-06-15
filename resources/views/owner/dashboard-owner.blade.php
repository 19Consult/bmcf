@extends('layouts.app')

@section('content')

    <main class="wrapper profile">
        @include("layouts.nav-menu-home", ['title_page' => $data['title_page']])
        <div class="dashboard-wrapper">
            @include("layouts.sidebar")
            <div class="dashboard__wrapper projects-wrapper">

                @if(false)
                <form class="project__search-bar" method="GET" action="">

                    <div class="project__search-field">
                        <input name="search_keyword" type="text" placeholder="Search by Keyword" value="{{$search_keyword}}">
                        <button class="search-btn" onchange="this.form.submit()"></button>
                    </div>

                    <div class="ui fluid search selection dropdown" style="width: auto;">
                        <input type="hidden" name="categories" value="{{(isset($categories) ) ? $categories : ''}}" onchange="this.form.submit()">
                        <i class="dropdown icon"></i>
                        <input class="search" tabindex="0">
                        <div class="default text">All Categories</div>
                        <div class="menu">
                            @foreach($data['category'] as $key => $val)
                                <div class="item" data-value="{{$val->category_name}}" >{{$val->category_name}}</div>
                            @endforeach
                        </div>
                    </div>

                    <a href="{{route("dashboardOwner")}}" class="btn--arrow btn--solid search-reset">Reset</a>

                </form>
                @endif

                <div class="dashboard-begin">

                    <div class="dashboard-s1">
                        <div class="title-dashboard">My projects</div>
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
                                                @php
                                                    $sector = '';
                                                    if(!empty($val->keyword1)){
                                                        $sector .= $val->keyword1 . ', ';
                                                    }
                                                    if(!empty($val->keyword2)){
                                                        $sector .= $val->keyword2 . ', ';
                                                    }
                                                    if(!empty($val->keyword3)){
                                                        $sector .= $val->keyword3;
                                                    }
                                                    $sector = trim($sector);
                                                    $sector = rtrim($sector, ',');
                                                @endphp
                                                <div class="project__subtitle">{{$sector}}</div>
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
                    <div class="dashboard-line"></div>
                    <div class="dashboard-s2">
                        <div class="title-dashboard">Angels under NDA</div>
                        @if(!empty($data['nda_list']) && isset($data['nda_list']) && count($data['nda_list']->toArray()) > 0)
                            <?php
                                $using_user = [];
                            ?>
                            @foreach($data['nda_list'] as $key => $val)
                                <?php
                                $user = App\Models\User::where('id', $val->user_id)->first();
                                if(empty($user->detail)){
                                    continue;
                                }
                                if(in_array($user->id, $using_user)){
                                    continue;
                                }else{
                                    $using_user[] = $user->id;
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
                                $sector = trim($sector);
                                $sector = rtrim($sector, ',');
                                ?>
                                <div class="project__item">
                                    <div class="project__item-wrap">
                                        <div class="project__img">
                                            <img src="{{isset($user->detail->photo) ? asset($user->detail->photo) : 'img/project-img.webp'}}" alt="User image"></div>
                                        <div class="project__content top">
                                            <div class="project__content-user-name"><a href="{{route("viewProfilePublic", ["id" => $user->id])}}">{{$user->detail->first_name}} {{$user->detail->last_name}}</a></div>
                                            <div class="project__content-user-sector">{{$sector}}</div>
                                            <div class="project__content-user-country">{{$country}}</div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        @else
                            <div class="error-search-project">Sorry, nothing found</div>
                        @endif


                            <div id="angel-more-list">

                            </div>

                            <button id="load-more-btn" class="btn-more-owner-angel">More</button>


                            <script>
                                document.addEventListener('DOMContentLoaded', function () {

                                    $(document).ready(function() {

                                        $.ajaxSetup({
                                            headers: {
                                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                            }
                                        });

                                        var offset = 0;
                                        var limit = 5;

                                        $.ajax({
                                            url: '{{ route("dashboardAgentsLoad") }}',
                                            method: 'POST',
                                            data: {
                                                offset: offset
                                            },
                                            success: function(response) {
                                                //console.log(response)
                                                if (response.data.length > 0) {

                                                    let title = `<div class="error-search-project angel-suggest">Suggested Angels</div>`;
                                                    $('#angel-more-list').append(title);
                                                    $('#angel-more-list').show();

                                                    response.data.forEach(function(angel) {
                                                        if (typeof angel.users_angel !== 'undefined' && typeof angel.users_angel.detail !== 'undefined' && angel.users_angel.detail != null) {

                                                            let sector = '';
                                                            if (angel.users_angel.detail.categorty1_investor) {
                                                                sector += angel.users_angel.detail.categorty1_investor + ', ';
                                                            }
                                                            if (angel.users_angel.detail.categorty2_investor) {
                                                                sector += angel.users_angel.detail.categorty2_investor + ', ';
                                                            }
                                                            if (angel.users_angel.detail.categorty3_investor) {
                                                                sector += angel.users_angel.detail.categorty3_investor;
                                                            }
                                                            sector = sector.trim();
                                                            sector = sector.replace(/,$/, '');

                                                            let angel_block = `<div class="project__item">
                                                                            <div class="project__item-wrap">
                                                                                <div class="project__img">
                                                                                    <img src="${angel.user_photo}" alt="User image"></div>
                                                                                <div class="project__content top">
                                                                                    <div class="project__content-user-name"><a href="${angel.link_angel}" target="_blank">${angel.users_angel.name}</a></div>
                                                                                    <div class="project__content-user-sector">${sector}</div>
                                                                                    <div class="project__content-user-country">${angel.country_angel}</div>
                                                                                </div>
                                                                            </div>
                                                                        </div>`;

                                                            $('#angel-more-list').append(angel_block);
                                                        }
                                                    });

                                                    offset += limit;

                                                    if (response.data.length < 5) {
                                                        $('#load-more-btn').remove();
                                                    }

                                                } else {
                                                    //$('#angel-more-list').hidden();
                                                    $('#load-more-btn').remove();
                                                }
                                            }
                                        });

                                        $('#load-more-btn').click(function() {

                                            $.ajax({
                                                url: '{{ route("dashboardAgentsLoad") }}',
                                                method: 'POST',
                                                data: {
                                                    offset: offset
                                                },
                                                success: function(response) {
                                                    //console.log(response)
                                                    if (response.data.length > 0) {

                                                        response.data.forEach(function(angel) {
                                                            if (typeof angel.users_angel !== 'undefined' && typeof angel.users_angel.detail !== 'undefined' && angel.users_angel.detail != null) {

                                                                let sector = '';
                                                                if (angel.users_angel.detail.categorty1_investor) {
                                                                    sector += angel.users_angel.detail.categorty1_investor + ', ';
                                                                }
                                                                if (angel.users_angel.detail.categorty2_investor) {
                                                                    sector += angel.users_angel.detail.categorty2_investor + ', ';
                                                                }
                                                                if (angel.users_angel.detail.categorty3_investor) {
                                                                    sector += angel.users_angel.detail.categorty3_investor;
                                                                }
                                                                sector = sector.trim();
                                                                sector = sector.replace(/,$/, '');

                                                                let angel_block = `<div class="project__item">
                                                                            <div class="project__item-wrap">
                                                                                <div class="project__img">
                                                                                    <img src="${angel.user_photo}" alt="User image"></div>
                                                                                <div class="project__content top">
                                                                                    <div class="project__content-user-name"><a href="${angel.link_angel}" target="_blank">${angel.users_angel.name}</a></div>
                                                                                    <div class="project__content-user-sector">${sector}</div>
                                                                                    <div class="project__content-user-country">${angel.country_angel}</div>
                                                                                </div>
                                                                            </div>
                                                                        </div>`;

                                                                $('#angel-more-list').append(angel_block);
                                                            }
                                                        });

                                                        offset += limit;

                                                         if (response.data.length < 5) {
                                                            $('#load-more-btn').remove();
                                                        }

                                                    } else {
                                                        $('#load-more-btn').text('No more entries').prop('disabled', true);
                                                    }

                                                }
                                            });
                                        });
                                    });

                                });
                            </script>


                    </div>
                </div>

            </div>
        </div>
    </main>

@endsection
