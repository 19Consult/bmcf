@extends('admin.loyout')

@section('content')
    <main class="wrapper admin-users">
                @include("admin.nav-menu", ['title_page' => $data['title_page']])
        <div class="dashboard-wrapper">
            @include("admin.sidebar")

            <div class="profile__wrapper">

                <form method="GET" action="{{ route('admin.users') }}" class="form-admin-sort">

                    <select name="sortOrder" onchange="this.form.submit()">
                        <option></option>
                        <option value="asc" {{ $sortOrder == 'asc' ? 'selected' : '' }}>ASC</option>
                        <option value="desc" {{ $sortOrder == 'desc' ? 'selected' : '' }}>DESC</option>
                    </select>

                    <select name="perPage" onchange="this.form.submit()">
                        <option></option>
                        <option value="20" {{ $perPage == 20 ? 'selected' : '' }}>20</option>
                        <option value="30" {{ $perPage == 30 ? 'selected' : '' }}>30</option>
                        <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                    </select>

                    <select class="class-sortField" name="sortField" onchange="this.form.submit()">
                        <option></option>
                        <option value="id" {{ $sortField == 'id' ? 'selected' : '' }}>Id</option>
                        <option value="last_name" {{ $sortField == 'last_name' ? 'selected' : '' }}>Last Name</option>
                        <option value="company_name" {{ $sortField == 'company_name' ? 'selected' : '' }}>Company name</option>
                        <option value="country" {{ $sortField == 'country' ? 'selected' : '' }}>Country</option>
                    </select>

                    <div class="form_input_wrap">
                        <input type="text" placeholder="Search" name="searchTerm" value="{{isset($searchTerm) ? $searchTerm : ''}}">
                    </div>

                    <button type="submit" class="btn btn--solid btn--arrow send send-form">Search</button>

                </form>

                @foreach($data['users'] as $user)

                    <?php
                    $userRole = \App\Models\Role::where('id', $user->role)->first();
                    ?>

                    <div class="container-user">
                        <div class="container-data-user">
                            <div class="section-1">
                                <div>User ID: {{($user->id)}}</div>
                                <div>Role: {{$userRole->name}}</div>
                                <div>Email: {{$user->email}}</div>
                                <div>Phone: {{!empty($user->detail->phone) ? $user->detail->phone : ''}}</div>
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
                                <div><a href="#" class="link-user-edit">Edit user</a></div>
                            </div>
                            <div class="section-2 section-3">
                                <div>
                                    @if($user->is_blocked)
                                        <form action="{{ route('admin.users.unblock', $user->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success link-user-edit">Unblock user</button>
                                        </form>
                                    @else
                                        <form action="{{ route('admin.users.block', $user->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger link-user-edit">Block user</button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                @endforeach

                    <div class="pagination">
                        {{ $data['users']->withQueryString()->links() }}
                    </div>
            </div>
        </div>
    </main>
@endsection
