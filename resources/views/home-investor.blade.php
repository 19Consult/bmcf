@extends('layouts.app')

@section('content')


<main class="wrapper projects-search-v2">
    @include("layouts.nav-menu-home")
    <div class="dashboard-wrapper">
        @include("layouts.sidebar")
        <div class="projects-wrapper">
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
                <a href="{{route("homeInvestor")}}" class="btn--arrow btn--solid search-reset">Reset</a>

            </form>

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
                                    @if( App\Models\NdaProjects::checkSignedNda(Auth::id(), $val->id) )
                                        <a class="project__title_link" href="{{route("viewProject", ['id' => $val->id])}}">{{isset($val->name_project) ? $val->name_project : ''}}</a>
                                    @else
                                        <div class="project__title counter-project-view" data-project-id="{{$val->id}}">{{isset($val->name_project) ? $val->name_project : ''}}</div>
                                    @endif

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
                                <div class="project__favorite favorite-projid-{{$val->id}} {{in_array($val->id, $data['favorite_project']) ? 'active' : ''}}" project-id="{{$val->id}}"></div>
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

                    <div class="pagination">
                        {{ $data['projects']->withQueryString()->links() }}
                    </div>

            @else
                <div class="error-search-project">Sorry, nothing found</div>
            @endif

            <script>
                document.addEventListener('DOMContentLoaded', function () {

                    $(document).ready(function () {

                        $('.select-list').select2();

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        $('.project-preview__popup .nav__back').click(function(){
                            $('.scrollbar-inner-ajax').scrollbar('destroy')
                        })

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
                                    $(".pr-user-full-name").text(data.user_deteils.first_name + ' ' + data.user_deteils.last_name.charAt(0))

                                    let company_name_owner = '';
                                    if(data.user_deteils.company_name !== null){
                                        company_name_owner = '(' + data.user_deteils.company_name + ')';
                                    }
                                    $('.nda-owner-name').text(data.user_deteils.first_name + ' ' + data.user_deteils.last_name + company_name_owner);

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

                                    $(".nda-id-project").val(project_id);

                                    if ($('.project-preview__wrap--page.open')) {
                                        setTimeout(() => {
                                            $('.scrollbar-inner-ajax').scrollbar();
                                        }, 400);
                                    }

                                    $(".image-podpis").val('');

                                    if(data.check_asses_status == "pending"){
                                        $(".rj-link-redirect").css("display", "none")
                                        $(".nav__back.already-request").css("display", "flex")
                                    }else {
                                        $(".nav__back.already-request").css("display", "none")
                                        $(".rj-link-redirect").css("display", "flex")
                                    }

                                    // let link = '/project/' + project_id;
                                    // $(".rj-link-redirect").attr('href', link)
                                },
                                error: function(xhr, textStatus, errorThrown) {
                                    console.log(xhr.responseText); // replace with your own error callback function
                                }
                            });

                        });

                        $('.nda-info__btn-confirm').click(function () {
                            var signature = document.getElementById("signature");
                            var signatureData = signature.toDataURL();

                            $(".image-podpis").val(signatureData);
                        })
                        $('.remove-signature').click(function () {
                            $(".image-podpis").val('');
                        })

                        $('.rj-link-redirect').click(function() {
                            $('.nda-agreement.nda-agreement--popup').addClass('open');
                        })

                        $('.nav__back a').click(function() {
                            $('.nda-agreement.nda-agreement--popup').removeClass('open');
                        })


                        // $('.project__favorite').click(function() {
                        //     var project_id = $(this).attr('project-id');
                        //     console.log(project_id)
                        //
                        //     let data = {
                        //         project_id: project_id,
                        //     };
                        //
                        //     $.ajax({
                        //         url: '/project/favorite',
                        //         method: 'POST',
                        //         data: data,
                        //         success: function(data) {
                        //             let favoriteClass = $(`.favorite-projid-${project_id}`);
                        //             let favoriteClassPopUp = $(`.favorite-pop`);
                        //             if(data.success){
                        //                 favoriteClass.addClass("active")
                        //                 favoriteClassPopUp.addClass("active")
                        //             }else {
                        //                 favoriteClass.removeClass("active")
                        //                 favoriteClassPopUp.removeClass("active")
                        //             }
                        //         },
                        //         error: function(xhr, textStatus, errorThrown) {
                        //             console.log(xhr.responseText); // replace with your own error callback function
                        //         }
                        //     });
                        // });



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
                                <div class="project-preview__interested-title">Angels Interested</div>
                                <div class="project-preview__interested-quantity">24</div>
                            </div>
                            <div class="project__favorite favorite-pop" project-id=""></div>
                        </div>
                        <div class="project-preview__description pr-project-story scrollbar-inner-ajax scrollbar-inner">Li Europan lingues es membres del sam familie. Lor separat existentie es un myth. Por scientie, musica, sport etc, litot Europa usa li sam vocabular. Li lingues differe solmen in li grammatica, li pronunciation e li plu commun vocabules. Omnicos directe al desirabilite de un nov lingua franca: On refusa continuar payar custosi traductores. At solmen va esser necessi far uniform grammatica, pronunciation e plu sommun paroles.</div>
                        <div class="project-preview__author">
                            <div class="project-preview__author-img"><img class="pr-user-photo" src="img/user-2.webp" alt="User"></div>
                            <div class="project-preview__author-title">
                                <div class="project-preview__author-name pr-user-full-name">Mariam Collier</div>
                                <div class="project-preview__author-position">Idea Owner</div>
                            </div>
                        </div>
                        <div class="project-preview__description pr-founder-terms-condition scrollbar-inner-ajax scrollbar-inner">Hello I’m Mariam Li lingues differe solmen in li grammatica, li pronunciation e li plu commun vocabules. Omnicos directe al desirabilite de un nov lingua franca: On refusa continuar payar custosi traductores. At solmen va esser necessi far uniform grammatica, pronunciation e plu sommun paroles.</div>
                        <a class="btn--arrow btn--solid rj-link-redirect" href="#">Sign NDA and request full project access</a>
                        <div class="nav__back already-request" style="display: none">
                            <a class=" btn--arrow btn--solid" href="#">ALREADY REQUESTED</a>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="nda-agreement nda-agreement--popup ">
            <div class="nda-agreement-wrap">
                <div class="nda-agreement--popup-content">
                    <nav class="nav">
                        <div class="nav__back"><a href="#">Go Back To Projects </a><span>The Athletic Buro Sign NDA</span></div>
                    </nav>
                    <form class="nda-agreement__text" action="{{route("saveNdaProject")}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" class="nda-id-project" name="id_project" value="0">
                        <input type="hidden" class="image-podpis" name="signature" value="" required>
                        <div class="title">NON-DISCLOSURE AGREEMENT (NDA)</div>
                        <p>
                            This Non-Disclosure Agreement (the "Agreement") is made and entered into on
                            <input class="input-date" type="text" name="date" readonly>
                            between
                            <b class="nda-owner-name"></b>
                            ("Disclosing Party")
                            and
                            <b>{{$nda_address_investor}}</b>
                            ("Receiving Party") (collectively, the "Parties").
                        </p>
                        <ol>
                            <li>
                                1.	Definition of Confidential Information Confidential Information means any and all non-public,
                                proprietary, confidential, or trade secret information, whether in written, oral, electronic,
                                or any other form, that is disclosed by the Disclosing Party to the Receiving Party.
                            </li>
                            </br>
                            <li>
                                2.	Obligations of Receiving Party The Receiving Party agrees to:
                            </li>
                            <ol>
                                <li>
                                    a. Protect Confidential Information: use its best efforts to maintain the confidentiality
                                    of the Disclosing Party's Confidential Information and to prevent any unauthorized use
                                    or disclosure of the Confidential Information;
                                </li>
                                <li>
                                    b. Limited Use: use the Confidential Information solely for the purpose of
                                    <b class="pr-name"></b>;
                                </li>
                                <li>
                                    c. Limited Disclosure: disclose the Confidential Information only to those of its employees,
                                    agents, or representatives who need to know the Confidential Information for the purpose
                                    set forth in Section 2(b) above and who have signed a copy of this Agreement or are
                                    otherwise bound by a similar obligation of confidentiality;
                                </li>
                                <li>
                                    d. Return or Destroy: promptly return or destroy all copies of the Confidential
                                    Information upon request of the Disclosing Party.
                                </li>
                            </ol>
                            </br>
                            <li>
                                3.	Exclusions The Receiving Party's obligations under this Agreement do not apply to information that:
                                <ol>
                                    <li>
                                        a. was rightfully in its possession or known to it prior to receipt from the Disclosing Party;
                                    </li>
                                    <li>
                                        b. is or becomes publicly available through no fault of the Receiving Party;
                                    </li>
                                    <li>
                                        c. is rightfully obtained by the Receiving Party from a third party without restriction as to use or disclosure;
                                    </li>
                                    <li>
                                        d. is independently developed by the Receiving Party without reference to the Disclosing Party's Confidential Information;
                                    </li>
                                    <li>
                                        e. is required to be disclosed by law or by a governmental authority, provided that the Receiving Party shall promptly
                                        notify the Disclosing Party of such requirement and cooperate with the Disclosing Party in seeking a protective order
                                        or other appropriate remedy.
                                    </li>
                                </ol>
                            </li>
                            </br>
                            <li>
                                4.	Term and Termination This Agreement shall remain in effect for a period of <b>3</b>
                                years from the date of this Agreement, unless terminated earlier by mutual agreement of the Parties or by the Disclosing
                                Party upon written notice to the Receiving Party. The obligations of confidentiality and non-use contained in this
                                Agreement shall survive any termination of this Agreement.
                            </li>
                            </br>
                            <li>
                                5.	Governing Law and Jurisdiction This Agreement shall be governed by and construed in accordance with the laws of
                                <b>insert governing law and jurisdiction</b>, and any dispute arising under this Agreement
                                shall be resolved exclusively by the courts of <b>England</b>.
                            </li>
                            </br>
                            <li>
                                6.	Entire Agreement This Agreement constitutes the entire understanding between the Parties with respect to the subject
                                matter hereof and supersedes all prior discussions, negotiations, and agreements between the Parties, whether
                                written or oral.
                            </li>
                        </ol>
                        <div class="nda-agreement__text-descr">
                            <div class="nda-agreement__text-bottom">
                                <div class="nda-info__bottom">
                                    <div class="nda-info__signature">
                                        <label>Your Signature</label>
                                        <canvas class="nda-info__signature-field" id="signature" width="300" height="69"></canvas>
                                        <div class="remove-signature">Remove signature</div>
                                    </div>
                                    <button type="submit" class="nda-info__btn-confirm btn btn--solid btn--arrow">Confirm and Sign</button>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>

    </div>
</main>


@endsection
