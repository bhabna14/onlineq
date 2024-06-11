@extends('includes.layout')
@section('container')
<!-- new user register section -->
<section class="register_form_wrap pt-5 pb-5">
    <div class="container">
        <div class="form">
            <div class="form-title">
                <div class="row">
                    <div class="col-md-8">
                        <h4>@lang('Registration')</h4>
                        <hr>
                    </div>
                </div>
            </div>
            <form action="{{ route('register.store') }}" id="ajaxForm" method="POST">
                @csrf
                <input type="hidden" name="user_id" value="{{ $user->user_id }}">
                <div class="row">
                    <div class="form-group pt-3 col-lg-3 col-md-4">
                        <label class="pb-2" for="user_first_name"><b>@lang('First Name')*</b></label>
                        <input type="text" class="form-control" name="user_first_name" id="user_first_name" placeholder="@lang('Enter first name')">
                        <p id="erruser_first_name" class="mb-0 text-danger em"></p>
                    </div>
                    <input type="hidden" name="role_id" value="3">
                    <div class="form-group pt-3 col-lg-2 col-md-4">
                        <label class="pb-2" for="user_last_name"><b>@lang('Last Name')*</b></label>
                        <input type="text" class="form-control" name="user_last_name" id="user_last_name" placeholder="@lang('Enter last name')">
                        <p id="erruser_last_name" class="mb-0 text-danger em"></p>
                    </div>
                    <div class="form-group pt-3 col-lg-2 col-md-4">
                        <label class="pb-2" for="user_dob"><b>@lang('Date of Birth') *</b></label>
                        <input type="date" class="form-control" name="user_dob" id="user_dob" placeholder="Enter DOB" max="{{ date('Y-m-d') }}">
                        <p id="erruser_dob" class="mb-0 text-danger em"></p>
                    </div>
                    <div class="form-group pt-3 col-lg-2 col-md-4">
                        <label class="pb-2" for="user_gender"><b>@lang('Gender')*</b></label>
                        <select class="form-control" name="user_gender" id="user_gender">
                            <option value="--Select Gender--">--@lang('Select Gender')--</option>
                            <option value="Male">@lang('Male')</option>
                            <option value="Female">@lang('Female')</option>
                        </select>
                        <p id="erruser_gender" class="mb-0 text-danger em"></p>
                    </div>
                    <div class="form-group pt-3 col-lg-3 col-md-4">
                        <label class="pb-2" for="user_id_proof"><b>@lang('Select Id')*</b></label>
                        <select class="form-control" name="id_proof_type_id" id="id_proof_type_id">
                            <option value="--Select Id Proof--">--@lang('Select Id Proof')--</option>
                            @foreach ($id_proof as $id_proof)
                                <option value="{{ $id_proof->id_proof_type_id }}">{{ $id_proof->id_proof }}</option>
                            @endforeach
                        </select>
                        <p id="errid_proof_type_id" class="mb-0 text-danger em"></p>
                    </div>
                    <div class="form-group pt-3 col-lg-3 col-md-4">
                        <label class="pb-2" for="user_id_number"><b>@lang('Id Card Number')*</b></label>
                        <input type="text" class="form-control" name="user_id_number" id="user_id_number"
                            placeholder="@lang('Enter id card number')">
                        <p id="erruser_id_number" class="mb-0 text-danger em"></p>
                    </div>
                    <div class="form-group pt-3 col-lg-3 col-md-4">
                        <label class="pb-2" for="phone"><b>@lang('Mobile Number')*</b></label>
                        <input type="text" class="form-control" name="phone" id="phone" maxlength="10" placeholder="@lang('Enter mobile number')" onkeypress="return isNumber(event)" autocomplete="true" value="{{ $user->phone }}" readonly>
                        <p id="errphone" class="mb-0 text-danger em"></p>
                    </div>
                    <div class="form-group pt-3 col-lg-3 col-md-4">
                        <label class="pb-2" for="email"><b>@lang('Email')</b></label>
                        <input type="text" class="form-control" name="email" id="email" placeholder="@lang('Enter email')" autocomplete="true">
                        {{-- <p id="erremail" class="mb-0 text-danger em"></p> --}}
                    </div>
                    <div class="form-group pt-3 col-lg-3 col-md-4">
                        <label class="pb-2" for="address"><b>@lang('Address')*</b></label>
                        <textarea name="user_address" id="user_address" class="form-control" placeholder="@lang('Enter address')" cols="30" rows="4"></textarea>
                        <p id="erruser_address" class="mb-0 text-danger em"></p>
                    </div>
                    <div class="form-group pt-3 mt-3 col-lg-3 col-md-4">
                        <button type="button" id="submitBtn" class="form-control btn red_btn">@lang('Submit')</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
