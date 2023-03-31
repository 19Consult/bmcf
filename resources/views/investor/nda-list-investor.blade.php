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
                                <div class="nda__item">{{$val['project']->name_project}}</div>
                                <div class="nda__item {{$status_class}}">{{$status_name}}</div>
                                <div class="nda__item nda__item--investor">{{$data['user_detail']->first_name}} {{$data['user_detail']->last_name}}</div>
                                <div class="nda__item">{{$val['owner']->first_name}} {{$val['owner']->last_name}}</div>
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
        </div>
    </div>
</main>

@endsection
