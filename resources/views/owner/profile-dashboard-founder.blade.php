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
                                    <input class="class-code-phone" type="hidden" name="code_phone" value="">
                                    <input type="tel" id="phone"  name="phone" required value="{{isset($data['userDetail']->phone) ? $data['userDetail']->phone : ''}}">
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
                                        <input type="file" name="photo" maxlength="524288" accept="image/*,image/jpeg" id="file-uploader"><span class="btn btn--solid btn--arrow btn--photo">Upload Photo</span>
                                    </label>
                                </div>
                                <span class="style-span-max-size">*max size 512 kB</span>
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
{{--                                    <select name="country" class="click-select-country select-list">--}}
{{--                                        <option selected="true" disabled="disabled" id="country" name="country">Select country</option>--}}
{{--                                        @foreach($data['allCountry'] as $key => $val)--}}
{{--                                            <option value="{{$key}}" {{(isset($data['userDetail']->country) && $data['userDetail']->country == $key) ? 'selected' : ''}}>{{$val}}</option>--}}
{{--                                        @endforeach--}}
{{--                                    </select>--}}
{{--                                    <label for="country">Country</label>--}}

                                    <div class="ui fluid search selection dropdown">
                                        <input type="hidden" name="country" value="{{(isset($data['userDetail']->country) ) ? $data['userDetail']->country : ''}}">
                                        <i class="dropdown icon"></i>
                                        <input class="search" tabindex="0">
                                        <div class="default text">Select country</div>
                                        <div class="menu">
                                            @foreach($data['allCountry'] as $key => $val)
                                                <div class="item click-div-country" data-value="{{$key}}" >{{$val}}</div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <label for="country">Country</label>
                                </div>
                                <div class="form_input_wrap city-checkbox">
{{--                                    <select name="city" class="click-select-cities select-list">--}}

{{--                                        @if(isset($data['userDetail']->city) && !empty(isset($data['userDetail']->city)))--}}
{{--                                            @foreach((new \App\Http\Controllers\CountryController)->getCities($data['userDetail']->country) as $val )--}}

{{--                                                <option {{($data['userDetail']->city == $val) ? 'selected' : ''}} value="{{$val}}" >{{$val}}</option>--}}
{{--                                            @endforeach--}}
{{--                                        @else--}}
{{--                                            <option selected="true" disabled="disabled" id="city" >Select city</option>--}}
{{--                                        @endif--}}

{{--                                    </select>--}}
{{--                                    <label for="city">City</label>--}}

                                    <div class="ui fluid search selection dropdown ples-city-change">
                                        <input class="city-select-class" type="hidden" name="city" value="{{(isset($data['userDetail']->city) ) ? $data['userDetail']->city : ''}}">
                                        <i class="dropdown icon"></i>
                                        <input class="search" tabindex="0">
                                        <div class="default text">Select city</div>
                                        <div class="menu list-cities-div">
                                            @if(isset($data['userDetail']->city) && !empty(isset($data['userDetail']->city)))
                                                @foreach((new \App\Http\Controllers\CountryController)->getCities($data['userDetail']->country) as $val )
                                                    <div class="item " data-value="{{$val}}" >{{$val}}</div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                    <label for="city">City</label>

                                </div>
                            </div>

                            <div class="row row-field">
                                <div class="form_input_wrap">
                                    <div class="form_input_wrap">
                                        <input type="text" id="city_other_name" placeholder="Your City" name="city_other_name" value="{{isset($data['userDetail']->city) ? $data['userDetail']->city : ''}}">
                                    </div>

                                    <input type="checkbox" name="city_other" id="city_other" {{(isset($data['userDetail']->city_other) && $data['userDetail']->city_other)? 'checked' : ''}} value="1">
                                    <label for="city_other">Specify the city manually</label>

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
                        <button type="submit" class="btn btn--solid btn--arrow send send-form">{{isset($data['userDetail']->first_name) ? 'Save' : 'Submit & Start Project'}}</button>
                    </div>

                </form>


            </div>
        </div>
    </main>

    <script src="{{asset("js/form.js")}}"> </script>
@endsection
