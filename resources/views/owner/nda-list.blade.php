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
                    <div class="nda__item">Investor</div>
                    <div class="nda__item">Idea Owner</div>
                    <div class="nda__item nda__item--sort-active nda__item--sort nda__item--sort-up">Contract Date</div>
                </div>
                <div class="nda__content scrollbar-inner">

                    @if(!empty($data['nda_list']) && isset($data['nda_list']))
                        @foreach($data['nda_list'] as $val)
                            <?php
                            $status_class = '';
                            $status_name = '';
                            if($val['nda']->status == 'signed'){
                                $status_class = 'nda__item--status-signed';
                                $status_name = 'Signed';
                            }elseif ($val['nda']->status == 'rejected'){
                                $status_class = 'nda__item--status-rejected';
                                $status_name = 'Rejected';
                            }else{
                                $status_class = 'nda__item--status-pending';
                                $status_name = 'Pending';
                            }

                            ?>
                            <div class="nda__row">
                                <div class="nda__item nda__item--title project-detail-rb" data-project-id="{{$val['project']->id}}" project-id="{{$val['project']->id}}">{{$val['project']->name_project}}</div>
                                <div class="nda__item {{$status_class}}">{{$status_name}}</div>
                                <div class="nda__item nda__item--investor">{{$val['investor']->first_name}} {{$val['investor']->last_name}}</div>
                                <div class="nda__item">{{$data['user_detail']->first_name}} {{$data['user_detail']->last_name}}</div>
                                <div class="nda__item nda__last">
                                    <div class="nda__date">{{date('d/m/Y', strtotime($val['nda']->created_at))}}</div>
                                    <a href="{{route("downloadNda", ['nda_id' => $val['nda']->id])}}" class="nda__download {{(empty($val['nda']->signature) || empty($val['nda']->signature_owner)) ? 'disabled-button' : ''}}"></a>
                                    <div class="nda__more"></div>
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
                                <div class="nda-info__user-type">Investor</div>
                            </div>
                        </div>
                        <div class="nda-info__read-more">Show Full NDA Body Text</div>
                    </div>
                    <div class="col">
                        <div class="nda-info__content">
                            <p class="pr-about-you">Hello I’m Mariam Li lingues differe solmen in li grammatica, li pronunciation e li plu commun vocabules. Omnicos directe al desirabilite de un nov lingua franca: On refusa continuar payar custosi traductores. At solmen va esser necessi far uniform grammatica, pronunciation e plu sommun paroles.</p>
                            <p>Hello I’m Mariam Li lingues differe solmen in li grammatica, li pronunciation e li plu commun vocabules. Omnicos directe al desirabilite de un nov lingua franca: On refusa continuar payar custosi traductores. At solmen va esser necessi far uniform grammatica, pronunciation e plu sommun paroles.</p>
                            <form action="{{route("confirmNdaProject")}}" method="POST" class="nda-info__bottom">
                                @csrf
                                <input type="hidden" class="image-podpis" name="signature_owner" value="" required>
                                <input type="hidden" class="project-id-form" name="project_id" value="">
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
                            <button type="submit" class="btn btn--solid delete-account send">Reject</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</main>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            $(document).ready(function () {

                $('.nda-info__btn-confirm').click(function () {
                    var signature = document.getElementById("signature");
                    var signatureData = signature.toDataURL();

                    $(".image-podpis").val(signatureData);
                })
                $('.remove-signature').click(function () {
                    $(".image-podpis").val('');
                })

                $('.project-detail-rb').on('click', function(event) {
                    event.preventDefault();

                    let project_id = $(this).attr("data-project-id");

                    console.log(project_id)

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });


                    let data = {
                        project_id: project_id,
                    };

                    $.ajax({
                        url: '/project/ajax-project-details',
                        type: 'POST',
                        data: data,
                        success: function(data) {

                            // console.log(data);
                            let project_data = data.project_detail;
                            $(".pr-name").text(project_data.name_project)

                            $(".pr-about-you").text(data.user_deteils.about_you)
                            $(".pr-user-photo").attr("src", data.user_deteils.photo)
                            $(".pr-user-full-name").text(data.user_deteils.first_name + ' ' + data.user_deteils.last_name)

                            $(".project-id-form").val(project_id);

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
