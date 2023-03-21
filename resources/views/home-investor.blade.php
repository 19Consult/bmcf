@extends('layouts.app')

@section('content')


<main class="wrapper projects-search-v2">
    @include("layouts.nav-menu-home")
    <div class="dashboard-wrapper">
        @include("layouts.sidebar")
        <div class="projects-wrapper">
            <form class="project__search-bar" method="GET" action="">

                <select>
                    <option selected="true" disabled="disabled">Selected for you</option>
                    <option>Content 1</option>
                    <option>Content 2</option>
                    <option>Content 3</option>
                    <option>Content 4</option>
                </select>
                <div class="project__search-field">
                    <input name="search_keyword" type="text" placeholder="Search by Keyword" value="{{$search_keyword}}">
                    <div class="search-btn"></div>
                </div>
                <select name="categories" class="categories" onchange="this.form.submit()">
                    <option></option>
                    <option selected="true" value="">All Categories</option>
                    @if(!empty($data['category']))
                        @foreach($data['category'] as $key => $val)
                            <option value="{{$val->category_name}}" {{ $categories == $val->category_name ? 'selected' : '' }}>{{$val->category_name}}</option>
                        @endforeach
                    @endif
                </select>

            </form>

            @if(!empty($data['projects']) && isset($data['projects']))
                @foreach($data['projects'] as $key => $val)
                    <?php $views = $val->views->first();?>
                    <div class="project__item">
                        <div class="project__item-wrap">
                            <div class="project__img"><img src="{{isset($val->photo_project) ? asset($val->photo_project) : 'img/project-img.webp'}}" alt="Project image"></div>
                            <div class="project__content top">
                                <div class="project__title-wrap">
                                    <div class="project__title counter-project-view" data-project-id="{{$val->id}}">{{isset($val->name_project) ? $val->name_project : ''}}</div>
                                    <div class="project__subtitle">Social</div>
                                </div>
                                <div class="project__favorite favorite-projid-{{$val->id}} {{in_array($val->id, $data['favorite_project']) ? 'active' : ''}}" project-id="{{$val->id}}"></div>
                            </div>
                            <div class="project__content bottom">
                                <div class="project__views">
                                    <div class="project__views-title">Project views</div>
                                    <div class="project__views-quantity pr-total_views-{{$val->id}}">{{!empty($views->total_views) ? $views->total_views : 0}}</div>
                                </div>
                                <div class="project__interested">
                                    <div class="project__interested-title">Investor Interested</div>
                                    <div class="project__interested-quantity">5</div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                    <div class="pagination">
                        {{ $data['projects']->withQueryString()->links() }}
                    </div>

            @endif

            <script>
                document.addEventListener('DOMContentLoaded', function () {

                    $(document).ready(function () {

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });


                        $('.counter-project-view').on('click', function(event) {
                            event.preventDefault();

                            let project_id = $(this).attr("data-project-id");

                            console.log(project_id)

                            let data = {
                                project_id: project_id,
                            };

                            $.ajax({
                                url: '/project/counter-projects-views',
                                type: 'POST',
                                data: data,
                                success: function(data) {
                                    console.log(data); // replace with your own success callback function
                                    let project_data = data.project_detail;
                                    $(".pr-name").text(project_data.name_project)
                                    $(".pr-total_views").text(data.data.total_views)
                                    $(".pr-total_views-" + project_data.id).text(data.data.total_views)
                                    $(".pr-project-story").html(project_data.brief_description)
                                    $(".pr-founder-terms-condition").html(project_data.co_founder_terms_condition)

                                    $(".pr-user-photo").attr("src", data.user_deteils.photo)
                                    $(".pr-user-full-name").text(data.user_deteils.first_name + ' ' + data.user_deteils.last_name)

                                    let photo_project = project_data.photo_project;
                                    if (photo_project !== null){
                                        $(".pr-photo-project").attr("src", photo_project)
                                    }else {
                                        $(".pr-photo-project").attr("src", "img/project-img-full.webp")
                                    }

                                    if(data.favorite_bool){
                                        $(".favorite-pop").addClass("active")
                                        $(".favorite-pop").attr("project-id", project_id)
                                    }

                                    let link = '/project/' + project_id;
                                    $(".rj-link-redirect").attr('href', link)
                                },
                                error: function(xhr, textStatus, errorThrown) {
                                    console.log(xhr.responseText); // replace with your own error callback function
                                }
                            });

                        });



                        $('.project__favorite').click(function() {
                            var project_id = $(this).attr('project-id');
                            console.log(project_id)

                            let data = {
                                project_id: project_id,
                            };

                            $.ajax({
                                url: '/project/favorite',
                                method: 'POST',
                                data: data,
                                success: function(data) {
                                    let favoriteClass = $(`.favorite-projid-${project_id}`);
                                    let favoriteClassPopUp = $(`.favorite-pop`);
                                    if(data.success){
                                        favoriteClass.addClass("active")
                                        favoriteClassPopUp.addClass("active")
                                    }else {
                                        favoriteClass.removeClass("active")
                                        favoriteClassPopUp.removeClass("active")
                                    }
                                },
                                error: function(xhr, textStatus, errorThrown) {
                                    console.log(xhr.responseText); // replace with your own error callback function
                                }
                            });
                        });



                    })

                });
            </script>

            <div class="project-preview"></div>
        </div>
        <div class="project-preview__wrap project-preview__wrap--page">
            <div class="project-preview__popup project-preview__popup--page">
                <nav class="nav">
                    <div class="nav__back"><a href="#">Go Back To Projects </a><span class="pr-name">The Athletic Buro</span></div>
                </nav>
                <div class="project-preview__content">
                    <div class="project-preview__img"><img class="pr-photo-project" src="img/project-img-full.webp" alt="Project img"></div>
                    <div class="project-preview__text">
                        <div class="project-preview__top">
                            <div class="project-preview__views">
                                <div class="project-preview__views-title">Project views</div>
                                <div class="project-preview__views-quantity pr-total_views">134</div>
                            </div>
                            <div class="project-preview__interested">
                                <div class="project-preview__interested-title">Investors Interested</div>
                                <div class="project-preview__interested-quantity">24</div>
                            </div>
                            <div class="project__favorite favorite-pop" project-id=""></div>
                        </div>
                        <div class="project-preview__description pr-project-story">Li Europan lingues es membres del sam familie. Lor separat existentie es un myth. Por scientie, musica, sport etc, litot Europa usa li sam vocabular. Li lingues differe solmen in li grammatica, li pronunciation e li plu commun vocabules. Omnicos directe al desirabilite de un nov lingua franca: On refusa continuar payar custosi traductores. At solmen va esser necessi far uniform grammatica, pronunciation e plu sommun paroles.</div>
                        <div class="project-preview__author">
                            <div class="project-preview__author-img"><img class="pr-user-photo" src="img/user-2.webp" alt="User"></div>
                            <div class="project-preview__author-title">
                                <div class="project-preview__author-name pr-user-full-name">Mariam Collier</div>
                                <div class="project-preview__author-position">Idea Owner</div>
                            </div>
                        </div>
                        <div class="project-preview__description pr-founder-terms-condition">Hello I’m Mariam Li lingues differe solmen in li grammatica, li pronunciation e li plu commun vocabules. Omnicos directe al desirabilite de un nov lingua franca: On refusa continuar payar custosi traductores. At solmen va esser necessi far uniform grammatica, pronunciation e plu sommun paroles.</div><a class="btn--arrow btn--solid rj-link-redirect" href="#">Sign NDA and request full project access</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>


@endsection
