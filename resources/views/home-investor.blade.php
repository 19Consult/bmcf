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

            @if(!empty($data['projects']) && isset($data['projects']) && $data['projects']->toArray()['total'] > 0)
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

            @else
                <div class="error-search-project">Sorry, nothing found</div>
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
                                    $('.project-preview__wrap--page').find('.scroll-wrapper').removeClass('scroll-wrapper')
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

                                    $(".nda-id-project").val(project_id);

                                    if ($('.project-preview__wrap--page.open')) {
                                        $('.scrollbar-inner').scrollbar();
                                    }

                                    $(".image-podpis").val('');

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
                        <div class="project-preview__description pr-project-story scrollbar-inner">Li Europan lingues es membres del sam familie. Lor separat existentie es un myth. Por scientie, musica, sport etc, litot Europa usa li sam vocabular. Li lingues differe solmen in li grammatica, li pronunciation e li plu commun vocabules. Omnicos directe al desirabilite de un nov lingua franca: On refusa continuar payar custosi traductores. At solmen va esser necessi far uniform grammatica, pronunciation e plu sommun paroles.</div>
                        <div class="project-preview__author">
                            <div class="project-preview__author-img"><img class="pr-user-photo" src="img/user-2.webp" alt="User"></div>
                            <div class="project-preview__author-title">
                                <div class="project-preview__author-name pr-user-full-name">Mariam Collier</div>
                                <div class="project-preview__author-position">Idea Owner</div>
                            </div>
                        </div>
                        <div class="project-preview__description pr-founder-terms-condition scrollbar-inner">Hello I’m Mariam Li lingues differe solmen in li grammatica, li pronunciation e li plu commun vocabules. Omnicos directe al desirabilite de un nov lingua franca: On refusa continuar payar custosi traductores. At solmen va esser necessi far uniform grammatica, pronunciation e plu sommun paroles.</div><a class="btn--arrow btn--solid rj-link-redirect" href="#">Sign NDA and request full project access</a>
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
                            This Nondisclosure Agreement or ("Agreement") has been entered into on the date of

                            <input class="input-date" type="text" name="date" required>
                            and is by and between:
                        </p>
                        <p>
                            Party Disclosing Information:

                            <input class="input-disclosing" type="text" name="disclosing" required>
                            with a mailing address <br> of

                            <input class="input-disclosing-mail" type="text" name="disclosing_mail" required>
                            (“Disclosing Party”).
                        </p>
                        <p>
                            Party Receiving Information:

                            <input class="input-receiving" type="text" name="receiving" required>
                            with a mailing address <br> of

                            <input class="input-receiving-mail" type="text" name="receiving_mail" required>
                            (“Receiving Party”).
                        </p>
                        <div class="nda-agreement__text-descr">
                            <p>For the purpose of preventing the unauthorized disclosure of Confidential Information as definedbelow. The parties agree to enter into a confidential relationship concerning the disclosure ofcertain proprietary and confidential information ("Confidential Information").</p>
                            <p>1. Definition of Confidential Information. For purposes of this Agreement, "ConfidentialInformation" shall include all information or material that has or could have commercial value orother utility in the business in which Disclosing Party is engaged. If Confidential Information is inwritten form, the Disclosing Party shall label or stamp the materials with the word "Confidential"or some similar warning. If Confidential Information is transmitted orally, the Disclosing Partyshall promptly provide writing indicating that such oral communication constituted ConfidentialInformation.</p>
                            <p>2. Exclusions from Confidential Information. Receiving Party's obligations under thisAgreement do not extend to information that is: (a) publicly known at the time of disclosure orsubsequently becomes publicly known through no fault of the Receiving Party; (b) discovered orcreated by the Receiving Party before disclosure by Disclosing Party; (c) learned by theReceiving Party through legitimate means other than from the Disclosing Party or DisclosingParty's representatives; or (d) is disclosed by Receiving Party with Disclosing Party's priorwritten approval.</p>
                            <p>3. Obligations of Receiving Party. Receiving Party shall hold and maintain the ConfidentialInformation in strictest confidence for the sole and exclusive benefit of the Disclosing Party.Receiving Party shall carefully restrict access to Confidential Information to employees,contractors and third parties as is reasonably required and shall require those persons to signnondisclosure restrictions at least as protective as those in this Agreement. Receiving Partyshall not, without the prior written approval of Disclosing Party, use for Receiving Party's benefit,publish, copy, or otherwise disclose to others, or permit the use by others for their benefit or tothe detriment of Disclosing Party, any Confidential Information. Receiving Party shall return toDisclosing Party any and all records, notes, and other written, printed, or tangible materials in itspossession pertaining to Confidential Information immediately if Disclosing Party requests it inwriting.</p>
                            <p>4. Time Periods. The nondisclosure provisions of this Agreement shall survive the terminationof this Agreement and Receiving Party's duty to hold Confidential Information in confidenceshall remain in effect until the Confidential Information no longer qualifies as a trade secret oruntil Disclosing Party sends Receiving Party written notice releasing Receiving Party from thisAgreement, whichever occurs first.</p>
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
