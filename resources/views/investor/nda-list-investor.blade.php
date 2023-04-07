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
                <div class="nda__content scrollbar-inner scrollbar-init">

                    @if(!empty($data['nda_list']) && isset($data['nda_list']))
                        @foreach($data['nda_list'] as $val)
                            <?php
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
                                    <div class="nda__more" style="display: none">
                                        <div class="nda__more-popup">
                                            <a href="#">Approve</a>
                                            <a href="#">Reject</a>
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
</main>

@endsection
