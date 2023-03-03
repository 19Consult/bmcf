@extends('layouts.app')

@section('content')

    <main class="wrapper profile">
        @include("layouts.nav-menu", ['title_page' => $data['title_page']])
        <div class="dashboard-wrapper">
            @include("layouts.sidebar")
            <div class="profile__wrapper">
                <form class="form-profile" action="{{route("profileSave")}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row base">
                        <div class="col title">Basic Info <span>*</span></div>
                        <div class="col fields">
                            <div class="col row-field">
                                <div class="form_input_wrap">
                                    <select name="salutation">
                                        <option selected="true" disabled="disabled" id="salutation">Select</option>
                                        @foreach(['Mr.', 'Ms.', 'Mrs.', 'Dr.', 'Prof.'] as $val)
                                            <option {{(isset($data['userDetail']->salutation) && $data['userDetail']->salutation == $val) ? 'selected' : ''}} >{{$val}}</option>
                                        @endforeach
                                    </select>
                                    <label for="salutation">Salutation</label>
                                </div>
                            </div>
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
                            <div class="col row-field">
                                <div class="form_input_wrap">
                                    <input type="date" id="date-of-birth" name="date_of_birth" required value="{{isset($data['userDetail']->date_of_birth) ? $data['userDetail']->date_of_birth : ''}}">
                                    <label for="date-of-birth">Date of Birth</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row contact">
                        <div class="col title">Contact<span>*</span></div>
                        <div class="col fields">
                            <div class="col row-field">
                                <div class="form_input_wrap">
                                    <input type="tel" id="phone" placeholder="+43 6XX XXXXXX" name="phone" required value="{{isset($data['userDetail']->phone) ? $data['userDetail']->phone : ''}}">
                                    <label for="phone">Phone</label>
                                </div>
                            </div>
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
                                    <div class="add-photo show" id="show-photo-wrapper">
                                        <div id="show-photo"><img src="{{isset($data['userDetail']->photo) ? asset($data['userDetail']->photo) : 'img/user.png'}}" alt="user"></div><span></span>
                                    </div>
                                    <label>
                                        <input type="file" name="photo"  accept="image/*,image/jpeg" id="file-uploader"><span class="btn btn--solid btn--arrow btn--photo">Upload Photo</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row about">
                        <div class="col title">About you</div>
                        <div class="col fields textarea">
                            <div class="form_input_wrap">
                                <textarea name="about_you" cols="30" rows="12">{{isset($data['userDetail']->about_you) ? $data['userDetail']->about_you : ''}}</textarea>
                                <label for="first-name">Tell more about yourself</label>
                            </div>
                        </div>
                    </div>
                    <div class="row company">
                        <div class="col title">Company</div>
                        <div class="col fields">
                            <div class="col row-field">
                                <div class="form_input_wrap">
                                    <input type="text" id="company-name" name="company_name" value="{{isset($data['userDetail']->company_name) ? $data['userDetail']->company_name : ''}}">
                                    <label for="company-name">Company Name (Optional)</label>
                                </div>
                            </div>
                            <div class="col row-field">
                                <div class="form_input_wrap">
                                    <input type="text" id="occupation" name="occupation" value="{{isset($data['userDetail']->occupation) ? $data['userDetail']->occupation : ''}}">
                                    <label for="occupation">Ocupation</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col title">Business Address</div>
                        <div class="col fields">

                            <div class="row row-field">
                                <div class="form_input_wrap">
                                    <select name="country" class="click-select-country">
                                        <option selected="true" disabled="disabled" id="country" name="country">Select country</option>
                                        @foreach($data['allCountry'] as $key => $val)
                                            <option value="{{$key}}" {{(isset($data['userDetail']->country) && $data['userDetail']->country == $key) ? 'selected' : ''}}>{{$val}}</option>
                                        @endforeach
                                    </select>
                                    <label for="country">Country</label>
                                </div>
                                <div class="form_input_wrap">
                                    <select name="city" class="click-select-cities">

                                        @if(isset($data['userDetail']->city) && !empty(isset($data['userDetail']->city)))
                                            @foreach((new \App\Http\Controllers\CountryController)->getCities($data['userDetail']->country) as $val )

                                                <option {{($data['userDetail']->city == $val) ? 'selected' : ''}} value="{{$val}}" >{{$val}}</option>
                                            @endforeach
                                        @else
                                            <option selected="true" disabled="disabled" id="city" name="city">Select city</option>
                                        @endif

                                    </select>
                                    <label for="city">City</label>
                                </div>
                            </div>

                            <div class="row row-field">
                                <div class="form_input_wrap">
                                    <input type="text" id="street" placeholder="Your Street " name="street" value="{{isset($data['userDetail']->street) ? $data['userDetail']->street : ''}}">
                                    <label for="street">Street</label>
                                </div>
                                <div class="form_input_wrap">
                                    <input type="text" id="house" placeholder="ex, 3/4" name="house" value="{{isset($data['userDetail']->house) ? $data['userDetail']->house : ''}}">
                                    <label for="house">House and Door Number</label>
                                </div>
                            </div>

                            <div class="row row-field">
                                <div class="form_input_wrap">
                                    <input type="text" id="postal-code" placeholder="Postal Code" name="postal_code" value="{{isset($data['userDetail']->postal_code) ? $data['userDetail']->postal_code : ''}}">
                                    <label for="postal-code">Postal Code</label>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="form-profile__bottom">
                        @if(\App\Models\accountDeletionConfirmation::checkDeletionConfirmation())
                            <div class="warning-box">Account deletion request sent</div>
                        @else
                            <a href="{{route("AccountDeletionConfirmation")}}" class="btn btn--solid delete-account send">Delete account</a>
                        @endif
                        <button type="submit" class="btn btn--solid btn--arrow send">Submit & Start Project</button>
                    </div>

                </form>

                
            </div>
        </div>
    </main>

@endsection
