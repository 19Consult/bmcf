@extends('layouts.app')

@section('content')


    <main class="wrapper projects-search-v2 notifications-page">
        @include("layouts.nav-menu-home", ['title_page' => $data['title_page']])
        <div class="dashboard-wrapper">
            @include("layouts.sidebar")
            <div class="projects-wrapper">

                @if(!Auth::user()->hasVerifiedEmail())
                    <div class="notifications-div notifications-notseen ">
                        <span class="icon-notif icon-notif-email"></span>
                        <form class="form-verified" method="POST" action="{{ route('verification.resend') }}">
                            @csrf
                            <button type="submit" class="btn-verified" style="font: inherit;">Email not verified</button>
                        </form>
                    </div>
                @endif

                @if($data['notificationsChat']['unread_count'] > 0)
                    @foreach($data['notificationsChat']['unseen_senders'] as $key => $val)
                        <a href="{{route("chat")}}" target="_blank" class="notifications-div notifications-notseen">
                            <span class="icon-notif icon-notif-chat"></span>
                            New message from {{$val['name']}}
                        </a>
                    @endforeach
                @endif


                @if(!empty($data['nda_notifications']) && isset($data['nda_notifications']))
                    @foreach($data['nda_notifications'] as $key => $val)
                        <a href="{{route("ndaList")}}" target="_blank" class="notifications-div notifications-notseen">
                            <span class="icon-notif icon-notif-nda"></span>
                            New request NDA
                        </a>
                    @endforeach
                @endif

{{--                @if(!empty($data['notifications']) && isset($data['notifications']) && $data['notifications']->toArray()['total'] > 0)--}}
{{--                    @foreach($data['notifications'] as $key => $val)--}}

{{--                        @if(!empty($val->url))--}}
{{--                            <a href="{{url($val->url)}}" target="_blank" class="notifications-div {{($val->seen == false) ? "notifications-notseen" : "notifications-seen"}}">--}}
{{--                                {{$val->text}}--}}
{{--                            </a>--}}
{{--                        @else--}}
{{--                            <div class="notifications-div {{($val->seen == false) ? "notifications-notseen" : "notifications-seen"}} ">--}}
{{--                                <span class="icon-notif icon-notif-nda"></span>{{$val->text}}--}}
{{--                            </div>--}}
{{--                        @endif--}}

{{--                    @endforeach--}}

{{--                    <div class="pagination">--}}
{{--                        {{ $data['notifications']->withQueryString()->links() }}--}}
{{--                    </div>--}}

{{--                @else--}}
{{--                    <div class="error-search-project">Sorry, nothing found</div>--}}
{{--                @endif--}}

                <div id="notifications-more-list" class="list-notifications">

                </div>

                <div id="load-more-btn" class="btn-view-more">View more</div>

            </div>


        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            $(document).ready(function() {

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                var offset = 0;
                var limit = 5;

                $.ajax({
                    url: '{{ route("notificationsAjax") }}',
                    method: 'POST',
                    data: {
                        offset: offset
                    },
                    success: function(response) {
                        //console.log(response)
                        if (response.data.length > 0) {

                            $('#notifications-more-list').show();

                            response.data.forEach(function(value) {

                                if(value.url){
                                    let class_seen = 'notifications-notseen';
                                    if(value.seen){
                                        class_seen = 'notifications-seen';
                                    }

                                    let content = `<a href="${value.url}" target="_blank" data-id="${value.id}" class="notifications-div ${class_seen}"><span class="icon-notif icon-notif-nda"></span>${value.text}</a>`;

                                    $('#notifications-more-list').append(content);
                                }else {
                                    let class_seen = 'notifications-notseen';
                                    if(value.seen){
                                        class_seen = 'notifications-seen';
                                    }

                                    let content = `<div class="notifications-div ${class_seen}" data-id="${value.id}"><span class="icon-notif icon-notif-nda"></span>${value.text}</div>`;

                                    $('#notifications-more-list').append(content);
                                }

                            });

                            offset += limit;

                            if (response.data.length < 5) {
                                $('#load-more-btn').remove();
                            }

                        } else {
                            //$('#angel-more-list').hidden();
                            $('#load-more-btn').remove();
                        }
                    }
                });

                $('#load-more-btn').click(function() {

                    $.ajax({
                        url: '{{ route("notificationsAjax") }}',
                        method: 'POST',
                        data: {
                            offset: offset
                        },
                        success: function(response) {
                            //console.log(response)
                            if (response.data.length > 0) {

                                response.data.forEach(function(value) {

                                    if(value.url){
                                        let class_seen = 'notifications-notseen';
                                        if(value.seen){
                                            class_seen = 'notifications-seen';
                                        }

                                        let content = `<a href="${value.url}" target="_blank" data-id="${value.id}" class="notifications-div ${class_seen}"><span class="icon-notif icon-notif-nda"></span>${value.text}</a>`;

                                        $('#notifications-more-list').append(content);
                                    }else {
                                        let class_seen = 'notifications-notseen';
                                        if(value.seen){
                                            class_seen = 'notifications-seen';
                                        }

                                        let content = `<div class="notifications-div ${class_seen}" data-id="${value.id}"><span class="icon-notif icon-notif-nda"></span>${value.text}</div>`;

                                        $('#notifications-more-list').append(content);
                                    }

                                });

                                offset += limit;

                                if (response.data.length < 5) {
                                    $('#load-more-btn').remove();
                                }

                            } else {
                                $('#load-more-btn').text('No more entries').prop('disabled', true);
                            }

                        }
                    });
                });

                $(document).on('click', '.notifications-div', function (event) {

                    let notificationId = $(this).attr('data-id');

                    //console.log(notificationId);

                    $.ajax({
                        url: `/notifications/${notificationId}/mark-as-read`,
                        type: 'POST',
                        data: [],
                        success: function(data) {
                            console.log(data);
                        },
                        error: function(xhr, textStatus, errorThrown) {
                            console.log(xhr.responseText);
                        }
                    });
                })

            });

        });
    </script>

    <style>
        .list-notifications{
            gap: 15px;
            display: flex;
            flex-direction: column;
        }
        .projects-wrapper {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-wrap: wrap;
            padding: 30px;
            width: 100%;
            height: 100%;
            max-width: 1300px;
            gap: 24px;
            flex-direction: column;
        }
        .btn-view-more {
            padding: 15px 15px;
            width: auto;
            border-radius: 10px;
            border: 1px solid #e5eaf5;
            display: flex;
            align-items: center;
            background: var(--color-2);
            cursor: pointer;
            margin: 0 auto;
        }

        .notifications-div {
            padding: 15px 15px;
            width: inherit;
            border-radius: 10px;
            border: 1px solid #e5eaf5;
            display: flex;
            align-items: center;
        }
        .notifications-div.notifications-notseen{
            background: var(--color-2);
            font-weight: 500;
        }
        .notifications-div.notifications-seen{

        }
        .notifications-page .projects-wrapper {
            gap: 15px;
        }

        .icon-notif{
            background-position: center;
            background-size: contain;
            margin-right: 10px;
            min-width: 20px;
            height: 20px;
            display: block;
        }
        .icon-notif-chat {
            background: url('./img/icon-chat-notif.svg') no-repeat;
        }
        .icon-notif-nda{
            background: url('./img/icon-file-notif.svg') no-repeat;
        }
        .icon-notif-email{
            background: url('./img/icon-user-notif.svg') no-repeat;
        }
    </style>

@endsection
