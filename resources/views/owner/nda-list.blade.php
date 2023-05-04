@extends('layouts.app')

@section('content')

<main class="wrapper nda-list">
    @include("layouts.nav-menu-home", ['title_page' => $data['title_page']])
    <div class="dashboard-wrapper">
        @include("layouts.sidebar")
        <div class="content-wrap">
            <div class="nda-wrap">
                <div class="nda__top">
                    <div class="nda__item">Project Name</div>
                    <div class="nda__item">STATUS</div>
                    <div class="nda__item">Angel</div>
                    <div class="nda__item">Idea Owner</div>
                    <div class="nda__item nda__item--sort-active nda__item--sort nda__item--sort-up">Contract Date</div>
                </div>
                <div class="nda__content scrollbar-inner scrollbar-init">

                    @if(!empty($data['nda_list']) && isset($data['nda_list']))
                        @foreach($data['nda_list'] as $val)
                            <?php
                            $status_class = '';
                            $status_name = '';

                            $name_investor = '';
                            $name_owner = '';

                            if( isset($val['investor']->first_name) && !empty($val['investor']->first_name) ){
                                $name_investor = $val['investor']->first_name;
                                if( !empty($val['investor']->last_name) ){
                                    $name_investor .=  ' ' . substr($val['investor']->last_name, 0, 1);
                                }
                            }

                            if(isset($data['user_detail']->first_name) && !empty($data['user_detail']->first_name)){
                                $name_owner = $data['user_detail']->first_name;
                                if (!empty($data['user_detail']->last_name)){
                                    $name_owner .= ' ' . substr($data['user_detail']->last_name, 0, 1);
                                }
                            }

                            if($val['nda']->status == 'signed'){
                                $status_class = 'nda__item--status-signed';
                                $status_name = 'Signed';
                                if(isset($val['investor']->first_name)){
                                    $name_investor = $val['investor']->first_name . ' ' . $val['investor']->last_name;
                                }
                                if(isset($data['user_detail']->first_name)){
                                    $name_owner = $data['user_detail']->first_name . ' ' . $data['user_detail']->last_name;
                                }

                            }elseif ($val['nda']->status == 'rejected'){
                                $status_class = 'nda__item--status-rejected';
                                $status_name = 'Rejected';
                            }else{
                                $status_class = 'nda__item--status-pending';
                                $status_name = 'Pending';
                            }

                            ?>
                            <div class="nda__row">
                                @if($val['nda']->status == 'signed')
                                    <a class="project__title_link_nda_list" target="_blank" href="{{route("viewProject", ['id' => $val['project']->id])}}">{{$val['project']->name_project}}</a>
                                @else
                                    <div class="nda__item nda__item--title project-detail-rb" data-nda-id="{{$val['nda']->id}}" data-project-id="{{$val['project']->id}}" project-id="{{$val['project']->id}}">{{$val['project']->name_project}}</div>
                                @endif

                                <div class="nda__item {{$status_class}}">{{$status_name}}</div>
                                <div class="nda__item nda__item--investor">{{$name_investor}}</div>
                                <div class="nda__item">{{$name_owner}}</div>
                                <div class="nda__item nda__last">
                                    <div class="nda__date">{{date('d/m/Y', strtotime($val['nda']->created_at))}}</div>
                                    <a href="{{route("downloadNda", ['nda_id' => $val['nda']->id])}}" class="nda__download {{(empty($val['nda']->signature) || empty($val['nda']->signature_owner)) ? 'disabled-button' : ''}}"></a>
                                    <div class="nda__more" >
                                        <div class="nda__more-popup">

                                            <div class="share-project-btn" data-nda-id="{{$val['nda']->id}}" data-project-id="{{$val['project']->id}}">Share Project</div>
                                            <div class="share-profile-btn" data-nda-id="{{$val['nda']->id}}" data-profile-id="{{$val['investor']->user_id}}">Share Profile</div>
                                            <div class="report-problem-btn" data-nda-id="{{$val['nda']->id}}" data-project-id="{{$val['project']->id}}" data-owner-id="{{Auth::id()}}">Report Problem</div>

                                            @if($val['nda']->status != 'signed')
                                                <div class="approve-click" data-nda-id="{{$val['nda']->id}}">Approve</div>
                                            @endif

                                            @if($val['nda']->status != 'rejected')
                                                <form action="{{route("rejectedNdaProject")}}" method="POST" class="list-reject-rt">
                                                    @csrf
                                                    <input type="hidden" class="project-id-form" name="project_id" value="{{$val['project']->id}}">
                                                    <input type="hidden" class="project-id-nda" name="nda_id" value="{{$val['nda']->id}}">
                                                    <button type="submit" class="">Reject</button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif

                </div>
            </div>
            <div class="nda-more-wrap">
                <nav class="nav">
                    <div class="nav__back"><a href="#">Go Back To Projects </a><span class="pr-name">The Athletic Buro</span></div>
                </nav>
                <div class="nda-info">
                    <div class="col left">
                        <div class="nda-info__user">
                            <div class="nda-info__user-img"><img class="pr-user-photo" src="img/user-2.webp" alt=""></div>
                            <div class="nda-info__user-name-wrap">
                                <div class="nda-info__user-name pr-user-full-name">Sam hill</div>
                                <div class="nda-info__user-type">Angel</div>
                            </div>
                        </div>
                        <div class="nda-info__read-more">Show Full NDA Body Text</div>
                    </div>
                    <div class="col">
                        <div class="nda-info__content">
                            <p class="pr-about-you">Hello I’m Mariam Li lingues differe solmen in li grammatica, li pronunciation e li plu commun vocabules. Omnicos directe al desirabilite de un nov lingua franca: On refusa continuar payar custosi traductores. At solmen va esser necessi far uniform grammatica, pronunciation e plu sommun paroles.</p>
                            <p style="display: none">Hello I’m Mariam Li lingues differe solmen in li grammatica, li pronunciation e li plu commun vocabules. Omnicos directe al desirabilite de un nov lingua franca: On refusa continuar payar custosi traductores. At solmen va esser necessi far uniform grammatica, pronunciation e plu sommun paroles.</p>
                            <form action="{{route("confirmNdaProject")}}" method="POST" class="nda-info__bottom">
                                @csrf
                                <input type="hidden" class="image-podpis signature-owner-owner" name="signature_owner" value="" required>
                                <input type="hidden" class="project-id-form" name="project_id" value="">
                                <input type="hidden" class="project-id-nda" name="nda_id" value="">
                                <div class="nda-info__signature">
                                    <label>Your Signature</label>
                                    <canvas class="nda-info__signature-field" id="signature" width="300" height="69"></canvas>
                                    <div class="remove-signature">Remove signature</div>
                                </div>
                                <button type="submit" class="nda-info__btn-confirm btn btn--solid btn--arrow nda-info__btn-confirm">Confirm and Sign</button>
                            </form>

                        </div>
                        <form action="{{route("rejectedNdaProject")}}" method="POST" class="rejected-nda-btn" >
                            @csrf
                            <input type="hidden" class="project-id-form" name="project_id" value="">
                            <input type="hidden" class="project-id-nda" name="nda_id" value="">
                            <button type="submit" class="btn btn--solid delete-account send">Reject</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>

        <div class="nda-agreement nda-agreement--popup ">
            <div class="nda-agreement-wrap">
                <div class="nda-agreement--popup-content">
                    <nav class="nav">
                        <div class="nav__back"><a href="#" class="close-nda">Go Back </a><span>The Athletic Buro Sign NDA</span></div>
                    </nav>
                    <form class="nda-agreement__text" >
                        <input type="hidden" class="nda-id-project" name="id_project" value="0">
                        <input type="hidden" class="image-podpis" name="signature" value="" required>
                        <div class="title">NON-DISCLOSURE AGREEMENT (NDA)</div>
                        <p>
                            This Non-Disclosure Agreement (the "Agreement") is made and entered into on
                            <input class="input-date" type="text" name="date" readonly>
                            between
                            <b class="nda-owner-name">{{$nda_owner_name}}</b>
                            ("Disclosing Party")
                            and
                            <b class="nda_address_investor"></b>
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
                                        <img class="nda-info__signature-field signature_owner" style="width: 300px; height: 69px;" width="300" height="69" src="">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>

        <div class="nda-agreement nda-agreement--popup report-popup">
            <div class="nda-agreement-wrap">
                <div class="nda-agreement--popup-content">
                    <nav class="nav">
                        <div class="nav__back"><a href="#">Go Back  </a> <span>Report Problem</span></div>
                    </nav>

                    <form class="report-form">
                        @csrf
                        <input type="hidden" class="project-id" name="project_id" value="">
                        <input type="hidden" class="to-user-id" name="to_user_id" value="">
                        <div class="form-group select-type">
                            <label for="type">Select problem type:</label>
                            <select class="form-control" id="type" name="type">
                                <option value="user">User</option>
                                <option value="project">Project</option>
                                <option value="other">Other</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="description">Description of the problem:</label>
                            <textarea class="form-control description-report" id="description" name="description" rows="3" maxlength="250"></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary btn--arrow btn--solid">Send</button>
                    </form>

                </div>
            </div>
        </div>

        <div class="nda-agreement nda-agreement--popup successful-popup">
            <div class="nda-agreement-wrap">
                <div class="nda-agreement--popup-content">
                    <nav class="nav">
                        <div class="nav__back"><a href="#">Go Back  </a></div>
                    </nav>
                    <div class="suses-div">
                        <p>Thank you for the Problem Report</p>
                        <img src="{{asset("img/icons/free-icon-check-1828640.svg")}}" />
                    </div>

                </div>
            </div>
        </div>

        <div class="nda-agreement nda-agreement--popup share-project-popup">
            <div class="nda-agreement-wrap">
                <div class="nda-agreement--popup-content">
                    <nav class="nav">
                        <div class="nav__back"><a href="#">Go Back  </a> <span>Share Project</span></div>
                    </nav>

                    <form class="share-project-form">
                        @csrf
                        <input type="hidden" class="project-id" name="project_id" value="">

                        <div class="form-group">
                            <label for="email_list">Specify a comma-separated email with whom you want to share the project</label>
                            <input class="form-control email_list" id="email_list" name="email_list">
                        </div>

                        <div class="form-group">
                            <label class="error-label-sher"></label>
                        </div>

                        <button type="submit" class="btn btn-primary btn--arrow btn--solid">Send</button>
                    </form>

                </div>
            </div>
        </div>

        <div class="nda-agreement nda-agreement--popup successful-popup share-project-successful">
            <div class="nda-agreement-wrap">
                <div class="nda-agreement--popup-content">
                    <nav class="nav">
                        <div class="nav__back"><a href="#">Go Back  </a></div>
                    </nav>
                    <div class="suses-div">
                        <p>Thanks for sharing the project</p>
                        <img src="{{asset("img/icons/free-icon-check-1828640.svg")}}" />
                    </div>

                </div>
            </div>
        </div>

        <div class="nda-agreement nda-agreement--popup share-profile-popup">
            <div class="nda-agreement-wrap">
                <div class="nda-agreement--popup-content">
                    <nav class="nav">
                        <div class="nav__back"><a href="#">Go Back  </a> <span>Share Profile</span></div>
                    </nav>

                    <form class="share-profile-form">
                        @csrf
                        <input type="hidden" class="profile-id" name="profile_id" value="">

                        <div class="form-group">
                            <label for="email_list_pr">Specify a comma-separated email with whom you want to share the profile</label>
                            <input class="form-control email_list_pr" id="email_list_pr" name="email_list">
                        </div>

                        <div class="form-group">
                            <label class="error-label-sher"></label>
                        </div>

                        <button type="submit" class="btn btn-primary btn--arrow btn--solid">Send</button>
                    </form>

                </div>
            </div>
        </div>
        <div class="nda-agreement nda-agreement--popup successful-popup share-profile-successful">
            <div class="nda-agreement-wrap">
                <div class="nda-agreement--popup-content">
                    <nav class="nav">
                        <div class="nav__back"><a href="#">Go Back  </a></div>
                    </nav>
                    <div class="suses-div">
                        <p>Thanks for sharing the profile</p>
                        <img src="{{asset("img/icons/free-icon-check-1828640.svg")}}" />
                    </div>

                </div>
            </div>
        </div>

    </div>
</main>

<style>
    .list-reject-rt button{
        cursor: pointer;
        background: unset;
        color: var(--color-3);
        padding: 0px;
    }
</style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            $(document).ready(function () {

                function isCanvasEmpty(canvas) {
                    const pixelBuffer = new Uint32Array(
                        canvas.getContext('2d').getImageData(0, 0, canvas.width, canvas.height).data.buffer
                    );
                    return !pixelBuffer.some(color => color !== 0);
                }


                let otherElement = $('.approve-click');
                otherElement.on('click', function() {
                    let id = $(this).attr("data-nda-id");
                    let targetElement = $('.project-detail-rb[data-nda-id="' + id + '"]');
                    targetElement.trigger('click');
                });


                $('.nda-info__btn-confirm').click(function () {
                    var signature = document.getElementById("signature");
                    var signatureData = signature.toDataURL();

                    if (isCanvasEmpty(signature)) {
                        alert('Signature required');
                    } else {
                        $(".image-podpis").val(signatureData);
                    }


                })
                $('.remove-signature').click(function () {
                    $(".image-podpis").val('');
                })

                $('.project-detail-rb').on('click', function(event) {
                    event.preventDefault();

                    let project_id = $(this).attr("data-project-id");
                    let data_nda_id = $(this).attr("data-nda-id");

                    //console.log(project_id)

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });


                    let data = {
                        project_id: project_id,
                        data_nda_id: data_nda_id,
                    };

                    $.ajax({
                        url: '/project/ajax-project-details',
                        type: 'POST',
                        data: data,
                        success: function(data) {

                            //console.log(data);
                            let project_data = data.project_detail;
                            $(".pr-name").text(project_data.name_project)

                            $(".pr-about-you").text(data.user_investor.about_you)
                            $(".pr-user-photo").attr("src", data.user_investor.photo)
                            $(".pr-user-full-name").text(data.user_investor.first_name + ' ' + data.user_investor.last_name.charAt(0))

                            $(".project-id-form").val(project_id);

                            $(".project-id-nda").val(data_nda_id);

                            //nda_address_investor
                            $(".nda_address_investor").text(data.nda_investor_name);
                            $(".signature_owner").attr("src", data.nda_projects.signature);


                        },
                        error: function(xhr, textStatus, errorThrown) {
                            console.log(xhr.responseText); // replace with your own error callback function
                        }
                    });

                    $.ajax({
                        url: '/project/seen-nda-project',
                        type: 'POST',
                        data: data,
                        success: function(data) {
                            console.log(data);
                        },
                        error: function(xhr, textStatus, errorThrown) {
                            console.log(xhr.responseText); // replace with your own error callback function
                        }
                    });

                });
            })
        })

    </script>

@endsection
