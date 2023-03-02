@extends('admin.loyout')

@section('content')
    <main class="wrapper admin-users">
        @include("admin.nav-menu", ['title_page' => $data['title_page']])
        <div class="dashboard-wrapper">
            @include("admin.sidebar")

            <div class="profile__wrapper">

                @if(!empty($data['users']))
                    @foreach($data['users'] as $val)

                        <?php
                        $user = $val[0];
                        $userRole = \App\Models\Role::where('id', $user->role)->first();
                        ?>

                        <div class="container-user">
                            <div class="container-data-user">
                                <div class="section-1">
                                    <div>User ID: {{($user->id)}}</div>
                                    <div>Role: {{$userRole->name}}</div>
                                    <div>Email: {{$user->email}}</div>
                                    <div>Salutation: {{!empty($user->detail->salutation) ? $user->detail->salutation : ''}}</div>
                                    <div>First Name: {{!empty($user->detail->first_name) ? $user->detail->first_name : ''}}</div>
                                    <div>Last Name: {{!empty($user->detail->last_name) ? $user->detail->last_name : ''}}</div>
                                    <div>Date of Birth: {{!empty($user->detail->date_of_birth) ? $user->detail->date_of_birth : ''}}</div>
                                    <div>Company name: {{!empty($user->detail->company_name) ? $user->detail->company_name : ''}}</div>
                                </div>
                                <div class="section-2">
                                    <div>Occupation: {{!empty($user->detail->occupation) ? $user->detail->occupation : ''}}</div>
                                    <div>Country: {{!empty($user->detail->country) ? (new \App\Http\Controllers\CountryController)->getNameCountry($user->detail->country) : ''}}</div>
                                    <div>City: {{!empty($user->detail->city) ? $user->detail->city : ''}}</div>
                                    <div>Street: {{!empty($user->detail->street) ? $user->detail->street : ''}}</div>
                                    <div>House: {{!empty($user->detail->house) ? $user->detail->house : ''}}</div>
                                    <div>Postal code: {{!empty($user->detail->postal_code) ? $user->detail->postal_code : ''}}</div>
                                    <div>Last Activity: {{!empty($user->last_activity_at) ? $user->last_activity_at : ''}}</div>
                                </div>
                                <div class="section-2 section-3">
                                    <div>
                                        <form action="{{ route('admin.users.delete', $user->id) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="email" value="{{$user->email}}">
                                            <button type="submit" class="btn btn-sm btn-success link-user-edit delete-user">Delete user</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    @endforeach
                @endif
            </div>
        </div>
    </main>
@endsection
