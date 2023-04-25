@extends('layouts.app')

@section('content')
<main class="wrapper project-create">
    @include("layouts.nav-menu-home")
    <div class="dashboard-wrapper">
        @include("layouts.sidebar")
        <div class="project-create-wrap">
            <div class="project-create-wrap-img"><img src="{{asset("img/create-project-bg.webp")}}" alt="Project background"></div>
            <div class="project-create__content-wrap">
                <div class="project-create__top">
                    <div class="project-create__top-img has-img"><img src="{{!empty($data['project']->photo_project) ? asset($data['project']->photo_project) : asset("img/icons/icon-add-photo.svg")}}" alt="Add photo"></div>
                    <div class="project-create__top-descr">
                        <div class="project-create__top-descr-top">
                            <div class="project-create__top-descr-top-title">{{!empty($data['project']->name_project) ? $data['project']->name_project : ''}}<span>100%</span></div>
                            <div class="project-create__top-descr-top-type">
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
                        <div class="field-text">
                            @if(!empty($data['project']->brief_description))
                                <p>{{$data['project']->brief_description}}</p>
                            @endif
                        </div>
                    </div>
                    <div class="project-create__top-right">
                        <div class="project-create__top-right-top">
                            <div class="project-preview__author">
                                <div class="project-preview__author-img"><img src="{{asset($data['user_photo'])}}" alt="User"></div>
                                <div class="project-preview__author-title">
                                    <div class="project-preview__author-name">{{!empty($data['first_name']) ? $data['first_name'] : ''}} {{!empty($data['last_name']) ? $data['last_name'] : ''}}</div>
                                    <div class="project-preview__author-position">Idea Owner</div>
                                </div>
                                <div class="project-preview__author-favorite project__favorite favorite-projid-{{$data['project']->id}} {{!empty($data['favorite_project']) ? 'active' : ''}}" project-id="{{$data['project']->id}}"></div>
                            </div>
                            <a href="{{route('user', ['id' => $data['project']->user_id])}}" class="project-create__top-right-send btn--solid btn--arrow btn--contact btn">Contact Owner</a>
                        </div>
                        <div class="project-create__top-right-bottom full">
                            <?php $views = $data['project']->views->first();?>
                            <div class="left">Project views<span>{{!empty($views->total_views) ? $views->total_views : 0}}</span></div>
                            <div class="right">Angel Interested<span>24</span></div>
                        </div>
                    </div>
                </div>

                <script>
                    document.addEventListener('DOMContentLoaded', function () {

                        $(document).ready(function () {
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
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

                                        if(data.success){
                                            favoriteClass.addClass("active")
                                        }else {
                                            favoriteClass.removeClass("active")
                                        }
                                    },
                                    error: function(xhr, textStatus, errorThrown) {
                                        console.log(xhr.responseText); // replace with your own error callback function
                                    }
                                });
                            });
                        });
                    });
                </script>

                <form class="form-profile project-form" action="">
                    <div class="row project-field">
                        <div class="col title">Project Story</div>
                        <div class="col fields">
                            <div class="col row-field">
                                <div class="form_input_wrap full-text">
                                    @if(!empty($data['project']->project_story))
                                        {!! $data['project']->project_story !!}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row project-video">
                        <div class="col title">Video Teaser </div>
                        <div class="col fields">
                            <div class="col row-field">
                                <a href="{{!empty($data['project']->youtube_link) ? $data['project']->youtube_link : ''}}">{{!empty($data['project']->youtube_link) ? $data['project']->youtube_link : ''}}</a>
                            </div>
                            <div class="col row-field">
                                <a href="{{!empty($data['project']->vimeo_link) ? $data['project']->vimeo_link : ''}}">{{!empty($data['project']->vimeo_link) ? $data['project']->vimeo_link : ''}}</a>
                            </div>
                        </div>
                    </div>
                    <div class="row project-plan">
                        <div class="col title">Business Plan</div>
                        <div class="col fields">
                            <div class="col row-field">
                                <div class="form_input_wrap full-text">
                                    @if(!empty($data['project']->business_plan))
                                        {!! $data['project']->business_plan !!}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col title">CoFounder Terms & Conditions</div>
                        <div class="col fields">
                            <div class="col row-field">
                                <div class="form_input_wrap">
                                    @if(!empty($data['project']->co_founder_terms_condition))
                                        {!! $data['project']->co_founder_terms_condition !!}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row project-idea">
                        <div class="col title">Project Idea Owner
                            <div class="project-preview__author">
                                <div class="project-preview__author-img"><img src="{{asset($data['user_photo'])}}" alt="User"></div>
                                <div class="project-preview__author-title">
                                    <div class="project-preview__author-name">{{!empty($data['first_name']) ? $data['first_name'] : ''}} {{!empty($data['last_name']) ? $data['last_name'] : ''}}</div>
                                    <div class="project-preview__author-position">Idea Owner</div>
                                </div>
                            </div>
                        </div>
                        <div class="col fields">
                            <div class="col title">About Owner</div>
                            <div class="col row-field">
                                <div class="form_input_wrap">
                                    <p>{{!empty($data['about_you']) ? $data['about_you'] : ''}}</p>
                                </div>
                            </div>
                        </div>
                    </div><a href="{{route('user', ['id' => $data['project']->user_id])}}" class="btn btn--solid btn--arrow btn--contact send">Contact Owner</a>
                </form>
            </div>
        </div>
        <div class="nda-agreement nda-agreement--popup ">
            <div class="nda-agreement-wrap">
                <div class="nda-agreement--popup-content">
                    <nav class="nav">
                        <div class="nav__back"><a href="#">Go Back To Projects </a><span>The Athletic Buro Sign NDA</span></div>
                    </nav>
                    <form class="nda-agreement__text">
                        <div class="title">NON-DISCLOSURE AGREEMENT (NDA)</div>
                        <p>
                            This Nondisclosure Agreement or ("Agreement") has been entered into on the date of

                            <input class="input-date" type="text" name="date">
                            and is by and between:
                        </p>
                        <p>
                            Party Disclosing Information:

                            <input class="input-disclosing" type="text" name="disclosing">
                            with a mailing address <br> of

                            <input class="input-disclosing-mail" type="text" name="disclosing-mail">
                            (“Disclosing Party”).
                        </p>
                        <p>
                            Party Receiving Information:

                            <input class="input-receiving" type="text" name="receiving">
                            with a mailing address <br> of

                            <input class="input-receiving-mail" type="text" name="receiving-mail">
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
                                    <div class="nda-info__btn-confirm btn btn--solid btn--arrow">Confirm and Sign</div>
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
