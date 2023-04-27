@extends('admin.loyout')

@section('content')
    <main class="wrapper admin-users">
        @include("admin.nav-menu", ['title_page' => $data['title_page']])
        <div class="dashboard-wrapper">
            @include("admin.sidebar")

            <div class="profile__wrapper">
                @if(isset($data['reportProblems']) && !empty($data['reportProblems']))
                    @foreach($data['reportProblems'] as $var)

                        @php
                        if(empty($var->form_user_id) || empty($var->project_id)){
                            continue;
                        }
                        $user = \App\Models\User::where('id', $var->form_user_id)->first();
                        $project = \App\Models\Projects::where('id', $var->project_id)->first();

                        if(empty($project->user_id)){
                            continue;
                        }
                        $owner = \App\Models\User::where('id', $project->user_id)->first();
                        @endphp

                        <div class="container-user">
                            <div class="container-data-user">
                                <div class="section-1">
                                    <div><b>Request sent</b></div>
                                    <div>User ID: {{$user->id}}</div>
                                    <div>Name: {{$user->detail->first_name}} {{$user->detail->last_name}}</div>
                                    <div>Email: {{$user->email}}</div>
                                    <div></div>
                                    <div><b>Project</b></div>
                                    <div>Project ID: {{$var->project_id}}</div>
                                    <div>Project Name: {{$project->name_project}}</div>
                                    <div></div>
                                    <div><b>Project Owner</b></div>
                                    <div>Owner ID: {{$owner->id}}</div>
                                    <div>Owner Name: {{$owner->detail->first_name}} {{$owner->detail->last_name}}</div>
                                    <div>Owner Email: {{$owner->email}}</div>
                                </div>
                                <div class="section-2">
                                    <div><b>Problem Report</b></div>
                                    <div>Type: {{$var->type}}</div>
                                    <div>Date: {{$var->created_at}}</div>
                                    <div>Description: {{$var->description}}</div>
                                </div>
                                <div class="section-2 section-3">
                                    <div>

                                    </div>
                                </div>
                            </div>
                        </div>

                    @endforeach

                    <div class="pagination">
                        {{ $data['reportProblems']->withQueryString()->links() }}
                    </div>
                @endif
            </div>
        </div>
    </main>
@endsection
