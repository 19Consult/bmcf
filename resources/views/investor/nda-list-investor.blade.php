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

                                if(empty($val['owner']->user_id)){
                                    continue;
                                }

                                $status_class = '';
                                $status_name = '';

                                $name_investor = $data['user_detail']->first_name . ' ' . substr($data['user_detail']->last_name, 0, 1);
                                $name_owner = $val['owner']->first_name . ' ' . substr($val['owner']->last_name, 0, 1);

                                if($val['nda']->status == 'signed'){
                                    $status_class = 'nda__item--status-signed';
                                    $status_name = 'Signed';

                                    $name_investor = $data['user_detail']->first_name . ' ' . $data['user_detail']->last_name;
                                    $name_owner = $val['owner']->first_name . ' ' . $val['owner']->last_name;

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
                                    <div class="nda__item">{{$val['project']->name_project}}</div>
                                @endif

                                <div class="nda__item {{$status_class}}">{{$status_name}}</div>
                                <div class="nda__item nda__item--investor">{{$name_investor}}</div>
                                <div class="nda__item">{{$name_owner}}</div>
                                <div class="nda__item nda__last">
                                    <div class="nda__date">{{date('d/m/Y', strtotime($val['nda']->created_at))}}</div>
                                    <a href="{{route("downloadNda", ['nda_id' => $val['nda']->id])}}" class="nda__download {{(empty($val['nda']->signature) || empty($val['nda']->signature_owner)) ? 'disabled-button' : ''}}"></a>
                                    <div class="nda__more" >
                                        <div class="nda__more-popup">
                                            @php
                                            $data_profile_id = '';
                                            if(App\Models\User::checkInvestor()){
                                                $data_profile_id = $val['owner']->user_id;
                                            }else{
                                                $data_profile_id = $val['user_detail']->user_id;
                                            }
                                            @endphp
                                            <div class="share-project-btn" data-nda-id="{{$val['nda']->id}}" data-project-id="{{$val['project']->id}}">Share Project</div>
                                            <div class="share-profile-btn" data-nda-id="{{$val['nda']->id}}" data-profile-id="{{$data_profile_id}}">Share Profile</div>
                                            <div class="report-problem-btn" data-nda-id="{{$val['nda']->id}}" data-project-id="{{$val['project']->id}}" data-owner-id="{{$val['owner']->user_id}}">Report Problem</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif

                </div>
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



</main>

@endsection
