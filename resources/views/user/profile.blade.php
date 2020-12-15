@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">{{ __('Menu') }}</div>

                    <div class="card-body">
                        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-information" role="tab" aria-controls="v-pills-home" aria-selected="true">{{ __('Information') }}</a>
                                <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-change-password" role="tab" aria-controls="v-pills-profile" aria-selected="false">{{ __('Change password') }}</a>
                                <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-notifications" role="tab" aria-controls="v-pills-profile" aria-selected="false">{{ __('Notifications') }}</a>
                                <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-newsletters" role="tab" aria-controls="v-pills-profile" aria-selected="false">{{ __('Newsletters') }}</a>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">{{ __('Profile Information') }}</div>

                    <div class="card-body">
                        <div class="tab-content" id="v-pills-tabContent">
                            <div class="tab-pane fade show active" id="v-pills-information" role="tabpanel" aria-labelledby="v-pills-information-tab">
                                <div class="row">
                                    <div class="col-md-3">
                                        <img is="blah" class="img-fluid" src="@if ($userProfileInfo->avatar)  {{ asset('images/news/'.$item->image) }} @else {{ asset('images/users/avatar/user_defaults_avatar.png') }} @endif">
                                    <div id="blah">

                                    </div>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="custom-file">
                                            <input id="imgInp" type="file" name="image" class="custom-file-input @error('image') is-invalid @enderror" id="customFile">
                                            <label class="custom-file-label is-invalid" for="customFile" data-browse="{{ __('Choose') }}">{{ __('Avatar') }}</label>
                                        </div>
                                        <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                                    </div>
                                </div>
                                <div class="alert alert-success" id="success-alert" style="display: none;">
                                    <button type="button" class="close" data-dismiss="alert">x</button>
                                    <strong>{{ __('SuccessAlert') }}!</strong>
                                    {{ __('SuccessAlertText') }}
                                </div>
                                <div class="alert alert-danger" id="danger-alert" style="display: none;">
                                    <button type="button" class="close" data-dismiss="alert">x</button>
                                    <strong>{{ __('DangerAlert') }}!</strong>
                                    {{ __('DangerAlertText') }}
                                </div>

                                <form name="profileInfoEdit" id="profileInfoEdit">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="inputEmail4">Имя</label>
                                            <input type="text" class="form-control" id="name" name="name" placeholder="Имя" value="{{ $userProfileInfo->name }}">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="inputPassword4">Фамилия</label>
                                            <input type="text" class="form-control" id="surname" name="surname" placeholder="Фамилия" value="{{ $userProfileInfo->surname }}">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="inputPassword4">Отчество</label>
                                            <input type="text" class="form-control" id="middle_name" name="middle_name" placeholder="Отчество" value="{{ $userProfileInfo->middle_name }}">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label for="inputAddress">Телефон</label>
                                        <br>
                                        <input type="tel" class="form-control phone" id="phone" placeholder="+7903123456" value="{{ $userProfileInfo->phone }}">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="inputAddress2">Address 2</label>
                                        <input type="text" class="form-control" id="inputAddress2" placeholder="Apartment, studio, or floor">
                                    </div>
                                        <div class="form-group col-md-4">
                                            <label for="inputAddress2">Address 2</label>
                                            <input type="text" class="form-control" id="inputAddress2" placeholder="Apartment, studio, or floor">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="inputCity">City</label>
                                            <input type="text" class="form-control" id="inputCity">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="inputState">State</label>
                                            <select id="inputState" class="form-control">
                                                <option selected>Choose...</option>
                                                <option>...</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="inputZip">Zip</label>
                                            <input type="text" class="form-control" id="inputZip">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="gridCheck">
                                            <label class="form-check-label" for="gridCheck">
                                                Check me out
                                            </label>
                                        </div>
                                    </div>
                                    <button type="submit" id="sendbtn" class="btn btn-primary">
                                        <span id="btnSpinner" class="spinner-border text-danger spinner-border-sm" role="status" aria-hidden="true" style="display: none;"></span>
                                        {{ __('Save') }}
                                    </button>
                                </form>

                                <script>
                                    var input = document.querySelector(".phone");
                                    window.intlTelInput(input, {
                                        initialCountry: "ru",
                                        separateDialCode: true,
                                        preferredCountries: ["ru","by","ua","kz"],
                                        geoIpLookup: function(callback) {
                                            $.get('https://ipinfo.io', function() {}, "jsonp").always(function(resp) {
                                                var countryCode = (resp && resp.country) ? resp.country : "";
                                                callback(countryCode);
                                            });
                                        },
                                        utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.14/js/utils.js"
                                    });
                                </script>


                                <script>
                                    $(document).ready (function(){
                                    $("#profileInfoEdit").submit(function(e) {
                                        e.preventDefault();
                                        let name = $("#name").val();
                                        let surname = $("#surname").val();
                                        let middle_name = $("#middle_name").val();
                                        let phone = $("#phone").val();
                                        let _token = $("input[name=_token]").val();
                                        $.ajax({
                                            url:"{{ route('user.profileAjaxEdit') }}",
                                            type:"PUT",
                                            data:{
                                                name:name,
                                                surname:surname,
                                                middle_name:middle_name,
                                                phone:phone,
                                                _token:_token
                                            },
                                            beforeSend: function() {
                                                $("#sendbtn").prop('disabled', true); // disable button
                                                $("#btnSpinner").show();
                                            },
                                            success:function(response){
                                                $("#name").val(response.name);
                                                $("#surname").val(response.surname);
                                                $("#middle_name").val(response.middle_name);
                                                $("#phone").val(response.phone);
                                                $("#sendbtn").prop('disabled', false); // enable button
                                                $("#success-alert").fadeTo(2000, 500).slideUp(500, function() {
                                                    $("#success-alert").slideUp(500);
                                                });
                                                $("#btnSpinner").hide();

                                            },error:function (response) {
                                                $("#danger-alert").fadeTo(2000, 500).slideUp(500, function() {
                                                    $("#danger-alert").slideUp(500);
                                                });
                                                $("#sendbtn").prop('disabled', false);
                                                $("#btnSpinner").hide();
                                            }
                                        })
                                    })
                                    });

                                </script>
                            </div>
                            <div class="tab-pane fade" id="v-pills-change-password" role="tabpanel" aria-labelledby="v-pills-change-password-tab">

                            </div>
                            <div class="tab-pane fade" id="v-pills-notifications" role="tabpanel" aria-labelledby="v-pills-notifications-tab">

                            </div>
                            <div class="tab-pane fade" id="v-pills-newsletters" role="tabpanel" aria-labelledby="v-pills-newsletters-tab">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
