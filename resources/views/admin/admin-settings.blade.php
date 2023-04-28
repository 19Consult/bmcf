@extends('admin.loyout')

@section('content')

    <main class="wrapper profile">
        @include("admin.nav-menu", ['title_page' => $data['title_page']])
        <div class="dashboard-wrapper">
            @include("admin.sidebar")
            <div class="profile__wrapper">
                <form class="form-profile" action="{{route("adminSettingsPageSave")}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row base">
                        <div class="col title">Basic Info <span>*</span></div>
                        <div class="col fields">

                            <div class="row row-field">
                                <div class="form_input_wrap">
                                    <input type="text" id="first-name" name="first_name" required value="{{isset($data['userDetail']->first_name) ? $data['userDetail']->first_name : ''}}">
                                    <label for="first-name">First Name</label>
                                </div>
                                <div class="form_input_wrap">
                                    <input type="text" id="last-name" name="last_name" required value="{{isset($data['userDetail']->last_name) ? $data['userDetail']->last_name : ''}}">
                                    <label for="last-name">Last Name</label>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="row contact">
                        <div class="col title">Contact<span>*</span></div>
                        <div class="col fields">

                            <div class="col row-field">
                                <div class="form_input_wrap">
                                    <input type="mail" id="mail" name="email" required value="{{$data['user']->email}}">
                                    <label for="mail">Your Email</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row picture">
                        <div class="col title">Profile Picture</div>
                        <div class="col fields picture">
                            <div class="col row-field">
                                <div class="form_input_wrap">
                                    <div class="add-photo {{isset($data['userDetail']->photo) ? 'show' : ''}}" id="show-photo-wrapper">
                                        <div id="show-photo">
                                            @if(isset($data['userDetail']->photo))
                                                <img src="{{isset($data['userDetail']->photo) ? asset($data['userDetail']->photo) : ''}}" alt="user">
                                            @else
                                                <img class="default-img-user display-none" src="" alt="user">
                                            @endif
                                        </div>
                                        <span></span>
                                    </div>
                                    <label>
                                        <input type="file" name="photo"  accept="image/*,image/jpeg" id="file-uploader"><span class="btn btn--solid btn--arrow btn--photo">Upload Photo</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="form-profile__bottom">

                        <button type="submit" class="btn btn--solid btn--arrow send send-form">Save</button>
                    </div>

                </form>


            </div>
        </div>
    </main>

    <script src="{{asset("js/form.js")}}"> </script>
@endsection
