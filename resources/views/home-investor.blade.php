@extends('layouts.app')

@section('content')


<main class="wrapper projects-search-v2">
    @include("layouts.nav-menu-home")
    <div class="dashboard-wrapper">
        @include("layouts.sidebar")
        <div class="projects-wrapper">
            <div class="project__search-bar">
                <select>
                    <option selected="true" disabled="disabled">Selected for you</option>
                    <option>Content 1</option>
                    <option>Content 2</option>
                    <option>Content 3</option>
                    <option>Content 4</option>
                </select>
                <div class="project__search-field">
                    <input type="text" placeholder="Search by Keyword">
                </div>
                <select class="categories">
                    <option selected="true" disabled="disabled">All Categories</option>
                    <option>Accommodation and Food Services</option>
                    <option>Food-Service Contractors</option>
                    <option>Restaurants</option>
                    <option>Takeaway & Fast-Food Restaurants</option>
                    <option>Hotels</option>
                    <option>Nightclubs & Bars</option>
                    <option>Administrative and Support Services </option>
                    <option>Call Centres</option>
                    <option>Employment Services</option>
                    <option>Office Equipment Rental & Leasing</option>
                    <option>Temporary-Employment Placement</option>
                    <option>Agriculture, Forestry and Fishing </option>
                    <option>Dairy</option>
                    <option>Flower & Plant Growing</option>
                    <option>Forestry & Logging</option>
                    <option>Fruit & Vegetable Growing</option>
                    <option>Marine Fishing</option>
                    <option>Poultry</option>
                    <option>Cattle and Sheep</option>
                    <option>Vet</option>
                    <option>Arts, Entertainment and Recreation </option>
                    <option>Amusement & Theme Parks</option>
                    <option>Botanical & Zoological Gardens</option>
                    <option>Gambling & Betting </option>
                    <option>Gyms & Fitness </option>
                    <option>Performing Arts</option>
                    <option>Photography</option>
                    <option>Cinema</option>
                    <option>Film and Theatre</option>
                    <option>Broadcasting</option>
                    <option>Construction & Building </option>
                    <option>Engineering & Technology</option>
                    <option>Construction & Project Management</option>
                    <option>Architecture</option>
                    <option>Landscaping Services</option>
                    <option>Pest Control</option>
                    <option>Equipment Rental & Leasing</option>
                    <option>Facilities Management & Security</option>
                    <option>Building & Industrial Cleaning</option>
                    <option>Building Materials</option>
                    <option>Education </option>
                    <option>General Secondary Education </option>
                    <option>Pre-Primary Education</option>
                    <option>Primary Education </option>
                    <option>Technical & Vocational </option>
                    <option>Universities </option>
                    <option>Energy </option>
                    <option>Electricity Distribution</option>
                    <option>Electricity Production</option>
                    <option>Electricity Supply</option>
                    <option>Electricity Transmission</option>
                    <option>Gas Distribution</option>
                    <option>Gas Supply</option>
                    <option>Energy Saving</option>
                    <option>Clean Energy</option>
                    <option>Financial and Insurance </option>
                    <option>Banking</option>
                    <option>Credit </option>
                    <option>Investment</option>
                    <option>Insurance</option>
                    <option>Tax</option>
                    <option>Technology</option>
                    <option>Human Health and Social Work Activities </option>
                    <option>Biotechnology </option>
                    <option>Child Care </option>
                    <option>Dental Health</option>
                    <option>Diagnostic & Ambulance Services</option>
                    <option>General Medical Practices </option>
                    <option>Hospitals</option>
                    <option>Learning Disability, Mental Health & Substance Abuse </option>
                    <option>Retirement and Residential Nursing Care</option>
                    <option>Social Services </option>
                    <option>Specialist Medical Technology</option>
                    <option>Information and Communication </option>
                    <option>Publishing (online/print)</option>
                    <option>Software Development</option>
                    <option>Computer Consultancy</option>
                    <option>Computer and Communications technology</option>
                    <option>Data Processing & Hosting Services</option>
                    <option>Manufacturing </option>
                    <option>Agricultural & Forestry</option>
                    <option>Aerospace</option>
                    <option>Communication Equipment</option>
                    <option>Computer & Peripheral Equipment</option>
                    <option>Consumer Electronics Manufacturing</option>
                    <option>Electrical Appliance</option>
                    <option>Engine & Turbine</option>
                    <option>Fertiliser & Nitrogen Compound</option>
                    <option>Fibre-Optic Cable </option>
                    <option>Food & Beverage Machinery</option>
                    <option>Iron & Steel Manufacturing</option>
                    <option>Kitchen Furniture Manufacturing</option>
                    <option>Medical & Dental Instrument Manufacturing</option>
                    <option>Motor Vehicle Manufacturing</option>
                    <option>Motorcycle Manufacturing</option>
                    <option>Paper & Paperboard Manufacturing</option>
                    <option>Pharmaceutical Preparations Manufacturing</option>
                    <option>Pet Food Manufacturing</option>
                    <option>Radiator & Boiler Manufacturing</option>
                    <option>Railway Equipment Manufacturing</option>
                    <option>Recreational Boat & Yacht Building</option>
                    <option>Sanitary Product Manufacturing</option>
                    <option>Mining and Quarrying </option>
                    <option>Mineral Mining</option>
                    <option>Natural Resource Extraction</option>
                    <option>Professional, Scientific and Technical Activities </option>
                    <option>Accounting & Auditing</option>
                    <option>Advertising</option>
                    <option>Legal</option>
                    <option>Management Consultancy</option>
                    <option>Market Research</option>
                    <option>Public Relations</option>
                    <option>Design</option>
                    <option>Real Estate Activities Agency</option>
                    <option>Management</option>
                    <option>Technology</option>
                    <option>Transportation and Storage </option>
                    <option>Services</option>
                    <option>Technology</option>
                    <option>Travel & Tourism </option>
                    <option>Tour Operators</option>
                    <option>Travel Agencies </option>
                    <option>Utilities </option>
                    <option>Services</option>
                    <option>Technology</option>
                    <option>Wholesale and Retail Trade </option>
                    <option>Services</option>
                    <option>Technology</option>
                    <option>Other</option>
                </select>
            </div>

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
                                    $(".pr-project-story").html(project_data.project_story)
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
