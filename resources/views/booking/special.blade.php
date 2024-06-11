@extends('includes.layout')
@section('container')
<!-- new user register section -->
<section class="register_form_wrap pt-5 pb-5">
    <div class="container">
        <div class="form">
            <form id="ajaxForm" action="{{ route('booking.store') }}" method="POST">
                @csrf
                <div class="form-title">
                    <div class="row">
                        <div class="col-md-8">
                            <h4>@lang('Specially Abled People Darshan Booking')</h4>
                            <hr>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group pt-3 col-lg-3 col-md-4">
                        <label class="pb-2" for="booking_date"><b>@lang('Select Date')*</b></label>
                        <input type="text" class="form-control" name="booking_date" id="datepicker"
                            placeholder="@lang('dd-mm-yyyy')" autocomplete="off">
                        <p id="errbooking_date" class="mb-0 text-danger em"></p>
                    </div>
                    <div class="form-group pt-3 col-lg-3 col-md-4">
                        <label class="pb-2"><b>@lang('Slots Available')</b></label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="available_slots" value=""
                                placeholder="@lang('Select date first')" disabled>
                        </div>
                    </div>
                    <input type="hidden" name="booking_type_id" value="1">
                    <div class="col d-flex align-items-center gap-2 pl-5 pt-3">
                        <div class="status-box available"></div>
                        <span class="label">@lang('Available')</span>

                        <div class="status-box not-available"></div>
                        <span class="label">@lang('Not Available')</span>
                    </div>
                    <div class="form-title pt-5">
                        <div class="row">
                            <div class="col-md-8">
                                <h4>@lang('Devotee Details')</h4>
                                <hr>
                            </div>
                        </div>
                    </div>

                    <div class="devotee_wrapper">
                        <div class="row">
                            <div class="form-group pt-3 col-lg-3 col-md-4">
                                <label class="pb-2" for="full_name"><b>@lang('Full Name')*</b></label>
                                <input type="text" class="form-control" name="full_name[]" id="full_name0"
                                    placeholder="@lang('Enter full name')" value="{{ $user_details->user_first_name }} {{ $user_details->user_last_name }}">
                                <p id="errfull_name" class="mb-0 text-danger em"></p>
                            </div>
                            <div class="form-group pt-3 col-lg-2 col-md-4">
                                <label class="pb-2" for="age"><b>@lang('Age')*</b></label>
                                <input type="text" class="form-control" name="age[]" placeholder="@lang('Enter age')" id="age0"
                                    onkeypress="return isNumber(event)" value="{{ $age }}">
                                <p id="errage" class="mb-0 text-danger em"></p>
                            </div>
                            <div class="form-group pt-3 col-lg-2 col-md-4">
                                <label class="pb-2" for="gender"><b>@lang('Gender')*</b></label>
                                <select class="form-control" name="gender[]" id="gender0">
                                    <option value="--@lang('Select Gender')--">--@lang('Select Gender')--</option>
                                    <option value="Male" {{ "Male" == $user_details->user_gender ? 'selected' : '' }}>@lang('Male')</option>
                                    <option value="Female" {{ "Female" == $user_details->user_gender ? 'selected' : '' }}>@lang('Female')</option>
                                </select>
                                <p id="errgender" class="mb-0 text-danger em"></p>
                            </div>
                            <div class="form-group pt-3 col-lg-2 col-md-4">
                                <label class="pb-2" for="id_proof"><b>@lang('Select Id')*</b></label>
                                <select class="form-control" name="id_proof_type_id[]" id="id_proof_type_id0">
                                    <option value="--@lang('Select Id Proof')--">--@lang('Select Id Proof')--</option>
                                    @forelse ($id_proof as $id_proof)
                                        <option value="{{ $id_proof->id_proof_type_id }}" {{ $id_proof->id_proof_type_id == $user_details->id_proof_type_id ? 'selected' : '' }}>{{ $id_proof->id_proof }}</option>
                                    @empty
                                    @endforelse
                                </select>
                                <p id="errid_proof_type_id" class="mb-0 text-danger em"></p>
                            </div>
                            <div class="form-group pt-3 col-lg-3 col-md-4">
                                <label class="pb-2" for="id_number"><b>@lang('Id Card Number')*</b></label>
                                <input type="text" class="form-control" name="id_number[]" value="{{ $user_details->user_id_number }}" placeholder="@lang('Enter id card number')" id="id_number0">
                                <p id="errid_number" class="mb-0 text-danger em"></p>
                            </div>
                            <div class="form-group pt-3 col-lg-3 col-md-4">
                                <label class="pb-2" for="file"><b>@lang('Specially Abled Certificate')*</b></label>
                                <input type="file" name="file" class="form-control" accept='.jpg,.jpeg,.pdf'>
                                <p id="errfile" class="mb-0 text-danger em"></p>
                            </div>
                            <div class="form-group pt-3 col-lg-3 col-md-4">
                                <label class="pb-2" for="image"><b>@lang('Full Photo')*</b></label>
                                <input type="file" name="image" class="form-control" accept='.jpg,.jpeg'>
                                <p id="errimage" class="mb-0 text-danger em"></p>
                            </div>
                            <div class="form-group pt-3 col-lg-3 col-md-4">
                                <label class="pb-2" for="phone"><b>@lang('Mobile Number')*</b></label>
                                <input type="text" class="form-control" name="phone[]" id="phone0" maxlength="10"
                                    placeholder="@lang('Enter mobile number')" onkeypress="return isNumber(event)"
                                    autocomplete="true" value="{{ $user_details->user->phone }}">
                                <p id="errphone" class="mb-0 text-danger em"></p>
                            </div>
                        </div>

                    </div>

                    <div class="form-title pt-5">
                        <div class="row">
                            <div class="col-md-8">
                                <h4>@lang('Attendant 1 Details (Mandatory)')</h4>
                                <hr>
                            </div>
                        </div>
                    </div>

                    <div class="devotee_wrapper">
                        <div class="row">
                            <div class="form-group pt-3 col-lg-3 col-md-4">
                                <label class="pb-2" for="full_name"><b>@lang('Full Name')*</b></label>
                                <input type="text" class="form-control" name="full_name[]" id="full_name1"
                                    placeholder="@lang('Enter full name')">
                                <p id="errfull_name" class="mb-0 text-danger em"></p>
                            </div>

                            <div class="form-group pt-3 col-lg-2 col-md-4">
                                <label class="pb-2" for="age"><b>@lang('Age')*</b></label>
                                <input type="text" class="form-control" name="age[]" id="age1" placeholder="@lang('Enter age')"
                                    onkeypress="return isNumber(event)">
                                <p id="errage" class="mb-0 text-danger em"></p>
                            </div>
                            <div class="form-group pt-3 col-lg-2 col-md-4">
                                <label class="pb-2" for="gender"><b>@lang('Gender')*</b></label>
                                <select class="form-control" name="gender[]" id="gender1">
                                    <option value="--@lang('Select Gender')--">--@lang('Select Gender')--</option>
                                    <option value="male">@lang('Male')</option>
                                    <option value="female">@lang('Female')</option>
                                </select>
                                <p id="errgender" class="mb-0 text-danger em"></p>
                            </div>
                            <div class="form-group pt-3 col-lg-2 col-md-4">
                                <label class="pb-2" for="id_proof_type"><b>@lang('Select Id')*</b></label>
                                <select class="form-control" name="id_proof_type_id[]" id="id_proof_type_id1">
                                    <option value="--@lang('Select Id Proof')--">--@lang('Select Id Proof')--</option>
                                    @foreach ($proof as $p)
                                        <option value="{{ $p->id_proof_type_id }}">{{ $p->id_proof }}</option>
                                    @endforeach
                                </select>
                                <p id="errid_proof_type_id" class="mb-0 text-danger em"></p>
                            </div>
                            <div class="form-group pt-3 col-lg-3 col-md-4">
                                <label class="pb-2" for="id_number"><b>@lang('Enter Id Card Number')*</b></label>
                                <input type="text" class="form-control" name="id_number[]" id="id_number1"
                                    placeholder="@lang('Enter id card number')">
                                <p id="errid_number" class="mb-0 text-danger em"></p>
                            </div>
                            <div class="form-group pt-3 col-lg-3 col-md-4">
                                <label class="pb-2" for="phone"><b>@lang('Mobile Number')*</b></label>
                                <input type="text" class="form-control" name="phone[]" id="phone1" maxlength="10"
                                    placeholder="@lang('Enter mobile number')" onkeypress="return isNumber(event)"
                                    autocomplete="true">
                                <p id="errphone" class="mb-0 text-danger em"></p>
                            </div>
                            <div class="form-group pt-3 col-lg-3 col-md-4">
                                <label class="pb-2" for="relation"><b>@lang('Relation')*</b></label>
                                <select name="relation_id[]" id="relation_id0" class="form-control">
                                    <option value="--@lang('Select Relation')--">--@lang('Select Relation')--</option>
                                    @foreach ($relation as $r)
                                        <option value="{{ $r->relation_id }}">{{ $r->relation }}</option>
                                    @endforeach
                                </select>
                                <p id="errrelation_id" class="mb-0 text-danger em"></p>
                            </div>
                        </div>

                    </div>

                    <div class="add_devotee pt-2" >
                        <button id="addAttendant"><b>+ @lang('Add Attendant (optional)')</b></button>
                    </div>
                    <div id="addPeople"></div>
                    <div class="ip-note mt-2">
                        <p><span class="text-danger">*@lang('Note')</span></p>
                        <p><b>&#8226;</b> @lang('At the time of verification, all the devotees should produce the same original Photo IDs furnished at the time of booking.Devotees will not be allowed to avail the service in case of any mismatch.')</p>
                    </div>
                    <div class="form-group pt-3 mt-3 col-lg-3 col-md-4 d-flex gap-2">
                        <button class="btn clr" type="button">@lang('Reset')</button>
                        <button type="button" class="form-control btn red_btn" id="submitBtn">@lang('Book Darshan')</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection

@section('script')
<script>
    $(document).ready(function () {

        var blockedDates = {!! $blocked_dates !!};
        var availableDates = {!! $available_dates !!};
        var startDate = moment().add(5, 'days').format('DD-MM-YYYY');
        var endDate = moment().add(11, 'days').format('DD-MM-YYYY');

        $("#datepicker").datepicker({
            format: "dd-mm-yyyy",
            startDate: startDate,
            endDate: endDate,
            orientation: "bottom",
            todayHighlight: false,
            datesDisabled: blockedDates
        }).on('show', function(e) {
            availableDates.forEach(element => {
                if (element.available) {
                    $('td[data-date="' + element.timestamp + '"]').addClass('bg-success text-white');
                } else {
                    $('td[data-date="' + element.timestamp + '"]').addClass('bg-danger text-white');
                }
            });
        });

    });

    /* ========== Append more time fields  ========== */

    let z=0;
    // var r=2;

    $("#addAttendant").click(function () {
        if(z<1){
            // var count = r+1;
            var fname=$("#full_name1").val();
            if(fname!=""){
                $("#addPeople").append(`<div class="form-title pt-5 removerow">
                        <div class="row">
                            <div class="col-md-8">
                                <h4>@lang('Attendant 2 Details')</h4>
                                <hr>
                            </div>
                        </div>
                    </div>
                    <div class="devotee_wrapper removerow">
                        <div class="row">
                            <div class="form-group pt-3 col-lg-3 col-md-4">
                                <label class="pb-2" for="full_name"><b>@lang('Full Name')*</b></label>
                                <input type="text" class="form-control" name="full_name[]" id="full_name2"
                                    placeholder="@lang('Enter full name')">
                                <p id="errfull_name" class="mb-0 text-danger em"></p>
                            </div>
                            <div class="form-group pt-3 col-lg-2 col-md-4">
                                <label class="pb-2" for="age"><b>@lang('Age')*</b></label>
                                <input type="text" class="form-control" name="age[]" id="age2" placeholder="@lang('Enter age')"
                                    onkeypress="return isNumber(event)">
                                <p id="errage" class="mb-0 text-danger em"></p>
                            </div>
                            <div class="form-group pt-3 col-lg-2 col-md-4">
                                <label class="pb-2" for="gender"><b>@lang('Gender')*</b></label>
                                <select class="form-control" name="gender[]" id="gender2">
                                    <option value="--@lang('Select Gender')--">--@lang('Select Gender')--</option>
                                    <option value="male">@lang('Male')</option>
                                    <option value="female">@lang('Female')</option>
                                </select>
                                <p id="errgender" class="mb-0 text-danger em"></p>
                            </div>
                            <div class="form-group pt-3 col-lg-2 col-md-4">
                                <label class="pb-2" for="id_proof_type"><b>@lang('Select Id')*</b></label>
                                <select class="form-control" name="id_proof_type_id[]" id="id_proof_type_id2">
                                    <option value="--@lang('Select Id Proof')--">--@lang('Select Id Proof')--</option>
                                    @foreach ($proof as $p)
                                        <option value="{{ $p->id_proof_type_id }}">{{ $p->id_proof }}</option>
                                    @endforeach
                                </select>
                                <p id="errid_proof_type_id" class="mb-0 text-danger em"></p>
                            </div>
                            <div class="form-group pt-3 col-lg-3 col-md-4">
                                <label class="pb-2" for="id_number"><b>@lang('Id Card Number')*</b></label>
                                <input type="text" class="form-control" name="id_number[]" id="id_number2"
                                    placeholder="@lang('Enter id card number')">
                                <p id="errid_number" class="mb-0 text-danger em"></p>
                            </div>
                            <div class="form-group pt-3 col-lg-3 col-md-4">
                                <label class="pb-2" for="phone"><b>@lang('Mobile Number')*</b></label>
                                <input type="text" class="form-control" name="phone[]" id="phone2" maxlength="10"
                                    placeholder="@lang('Enter mobile number')" onkeypress="return isNumber(event)"
                                    autocomplete="true">
                                <p id="errphone" class="mb-0 text-danger em"></p>
                            </div>
                            <div class="form-group pt-3 col-lg-3 col-md-4">
                                <label class="pb-2" for="relation"><b>@lang('Relation')*</b></label>
                                <select name="relation_id[]" id="relation_id1" class="form-control">
                                    <option value="--@lang('Select Relation')--">--@lang('Select Relation')--</option>
                                    @foreach ($relation as $r)
                                        <option value="{{ $r->relation_id }}">{{ $r->relation }}</option>
                                    @endforeach
                                </select>
                                <p id="errrelation_id" class="mb-0 text-danger em"></p>
                            </div>
                            <div class="form-group pt-3 col-lg-2 col-md-4" style="margin-top:32px">
                                    <button class="btn btn-danger deletebtn" id="removebtn">X</button>
                                </div>
                        </div>`);
                                // r++;
                z++;
                $("#removebtn").show();
            } else{
                alert("@lang('Please fillup previous fields')");
            }
        }else{
            alert("@lang('You Can Add Maximum 2 Attendants')");
        }

    });

    /* ==========   remove row    ========== */

    $(document).on('click', 'button.deletebtn', function () {
        $('.removerow').remove();
        z=0;
        return false;
    });


    $(document).on('change', 'input[name="booking_date"]', function() {

        $(".request-loader").addClass("show");
        var dateParam = $(this).val();

        $.ajax({
            url: "{{ route('available.slot') }}",
            type: 'GET',
            data: { date: dateParam, slug: 'specially-abled-booking' },
            success: function(response) {

                $(".request-loader").removeClass("show");
                // Handle the successful response here

                if (response.status === 'success') {
                    $('input[name="available_slots"]').val(response.data.available_slots);
                    toastr.options = {"positionClass": "toast-top-center"};
                    toastr.success(`${response.data.available_slots} ${response.data.available_slots > 1 ? 'slots' : 'slot' } available`);
                }
            },
            error: function(xhr, status, error) {
                return false;
            }
        });
    });
</script>
@endsection
