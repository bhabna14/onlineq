@extends('includes.layout')
@section('container')
<!-- new user register section -->
<section class="register_form_wrap pt-5 pb-5">
    <div class="container">
        <div class="form">
            <form id="ajaxBookingForm" action="{{ route('booking.store-darshan') }}" method="POST">
                @csrf
                <div class="form-title">
                    <div class="row">
                        <div class="col-md-8">
                            <h4>Darshan Booking</h4>
                            <small>(The cost for a single person's darshan is 100 rupees.)</small>
                            <hr>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group pt-3 col-lg-3 col-md-4">
                        <label class="pb-2" for="booking_date"><b>Select Date*</b></label>
                        <input type="text" class="form-control" name="booking_date" id="datepicker"
                            placeholder="dd-mm-yyyy" autocomplete="off">
                        <p id="errbooking_date" class="mb-0 text-danger em"></p>
                    </div>
                    <div class="form-group pt-3 col-lg-3 col-md-4">
                        <label class="pb-2"><b>Slots Available:</b></label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="available_slots" value=""
                                placeholder="Select date first" disabled>
                        </div>
                    </div>
                    {{-- <div class="form-group pt-3 col-lg-3 col-md-4">
                        <label class="pb-2" for="booking_date"><b>Select Date*</b></label>
                        <input type="date" class="form-control" name="booking_date" id="booking_date"
                            placeholder="Select date" min="{{ date('Y-m-d') }}"
                            max="{{ date('Y-m-d', strtotime('+6 days')) }}">
                        <p id="errbooking_date" class="mb-0 text-danger em"></p>
                    </div> --}}
                    <input type="hidden" name="booking_type_id" value="2">
                    <div class="col d-flex align-items-center gap-2 pl-5 pt-3">
                        <div class="status-box available"></div>
                        <span class="label">Available</span>

                        <div class="status-box not-available"></div>
                        <span class="label">Not Available</span>
                    </div>
                    <div class="form-title pt-5">
                        <div class="row">
                            <div class="col-md-8">
                                <h4>Devotee Details</h4>
                                <hr>
                            </div>
                        </div>
                    </div>

                    <div class="devotee_wrapper" id="addPeople">
                        <div class="row">
                            <div class="form-group pt-3 col-lg-2 col-md-4">
                                <label class="pb-2" for="full_name"><b>Full Name*</b></label>
                                <input type="text" class="form-control" name="full_name[]" id="full_name0"
                                    placeholder="Enter full name">
                                <p id="errfull_name" class="mb-0 text-danger em"></p>
                            </div>
                            <div class="form-group pt-3 col-lg-2 col-md-4">
                                <label class="pb-2" for="dob"><b>Age*</b></label>
                                <input type="text" class="form-control" name="age[]" id="age0" placeholder="Enter Age">
                                <p id="errage" class="mb-0 text-danger em"></p>
                            </div>
                            <div class="form-group pt-3 col-lg-2 col-md-4">
                                <label class="pb-2" for="gender"><b>Gender*</b></label>
                                <select class="form-control" name="gender[]" id="gender0">
                                    <option value="--Select Gender--">--Select Gender--</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                                <p id="errgender" class="mb-0 text-danger em"></p>
                            </div>
                            <div class="form-group pt-3 col-lg-2 col-md-4">
                                <label class="pb-2" for="id_proof"><b>Select Id*</b></label>
                                <select class="form-control" name="id_proof[]" id="id_proof0">
                                    <option value="--Select Id Proof--">--Select Id Proof--</option>
                                    <option value="Aadhaar card">Aadhaar Card</option>
                                    <option value="Pan Card">Pan Card</option>
                                </select>
                                <p id="errid_proof" class="mb-0 text-danger em"></p>

                            </div>
                            <div class="form-group pt-3 col-lg-2 col-md-4">
                                <label class="pb-2" for="id_number"><b>Enter Id Card Number*</b></label>
                                <input type="text" class="form-control" name="id_number[]" id="id_number0"
                                    placeholder="Enter id card number">
                                <p id="errid_number" class="mb-0 text-danger em"></p>
                            </div>
                            <div class="form-group pt-3 col-lg-2 col-md-4">
                                <label class="pb-2" for="phone"><b>Mobile Number*</b></label>
                                <input type="text" class="form-control" name="phone[]" id="phone0" maxlength="10"
                                    placeholder="Enter mobile number" onkeypress="return isNumber(event)"
                                    autocomplete="true">
                                <p id="errphone" class="mb-0 text-danger em"></p>
                            </div>
                        </div>
                    </div>
                    <div class="add_devotee pt-2">
                        <button id="addDevotee"><b>+ Add Devotee</b></button>
                    </div>
                    <div class="form-group pt-3 mt-3 col-lg-3 col-md-4 d-flex gap-2">
                        <button class="btn clr" type="button">Reset</button>
                        <button type="button" class="form-control btn red_btn" id="submitBooking">Pay 100</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection

@section('script')
<script>

    /* ***************************************************************
  ==========disabling default behave of form submits start==========
  *****************************************************************/

$("#ajaxBookingForm").attr("onsubmit", "return false");

/* *************************************************************
==========disabling default behave of form submits end==========
***************************************************************/

/* ***************************************************
  ==========Form Submit with AJAX Request Start==========
  ******************************************************/

$(document).on("click", "#submitBooking", function (e) {
    $(e.target).attr("disabled", true);
    $(".request-loader").addClass("show");

    let ajaxForm = document.getElementById("ajaxBookingForm");
    let fd = new FormData(ajaxForm);
    let url = $("#ajaxBookingForm").attr("action");
    let method = $("#ajaxBookingForm").attr("method");

    $.ajax({
        url: url,
        method: method,
        data: fd,
        contentType: false,
        processData: false,
        success: function (data) {
            $(e.target).attr("disabled", false);
            $(".request-loader").removeClass("show");

            $(".em").each(function () {
                $(this).html("");
            });
            console.log(data);
            if (data == "success") {
                location.href ="{{ route('booking.payment') }}";
            }

            // if error occurs
            else if (typeof data.error != "undefined") {
                for (let x in data) {
                    if (x == "error") {
                        continue;
                    }
                    if (x.includes(".")) {
                        document
                            .getElementById(x.replace(/\./g, ""))
                            .insertAdjacentHTML(
                                "afterend",
                                `<p class="mb-0 text-danger em">${data[x][0]}</p`
                            );
                    } else {
                        document.getElementById("err" + x).innerHTML =
                            data[x][0];
                    }
                }
            }
        },
        error: function (error) {
            $(".request-loader").removeClass("show");
            $(e.target).attr("disabled", false);

            $(".em").each(function () {
                $(this).html("");
            });

            for (let x in error.responseJSON.errors) {
                if (x.includes(".")) {
                    document
                        .getElementById(x.replace(/\./g, ""))
                        .insertAdjacentHTML(
                            "afterend",
                            `<p class="mb-0 text-danger em">${error.responseJSON.errors[x][0]}</p`
                        );
                } else {
                    console.log(x);
                    document.getElementById("err" + x).innerHTML =
                        error.responseJSON.errors[x][0];
                }
            }
        },
    });
});

/* ***************************************************
==========Form Submit with AJAX Request End==========
******************************************************/
    /* ========== Append more time fields  ========== */

    let z=0;
    var r=1;

    $("#addDevotee").click(function () {
        if(z<4){
            var count = r+1;
            var fname=$("#full_name"+z).val();
            if(fname!=""){
                $("#addPeople").append(`<div class="row" id="removerow${r}">
                                <div class="form-group pt-3 col-lg-2 col-md-4">
                                <label class="pb-2" for="full_name"><b>Full Name*</b></label>
                                <input type="text" class="form-control" name="full_name[]" id="full_name${r}" placeholder="Enter full name">
                                <p id="errfull_name" class="mb-0 text-danger em"></p>
                            </div>
                            <div class="form-group pt-3 col-lg-1 col-md-4">
                                <label class="pb-2" for="age"><b>Age*</b></label>
                                <input type="text" class="form-control" name="age[]" id="age${r}" placeholder="Enter Age">
                                <p id="errage" class="mb-0 text-danger em"></p>
                            </div>
                            <div class="form-group pt-3 col-lg-2 col-md-4">
                                <label class="pb-2" for="gender"><b>Gender*</b></label>
                                <select class="form-control" name="gender[]" id="gender${r}">
                                    <option value="--Select Gender--">--Select Gender--</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                                <p id="errgender" class="mb-0 text-danger em"></p>
                            </div>
                            <div class="form-group pt-3 col-lg-2 col-md-4">
                                <label class="pb-2" for="id_proof"><b>Select Id*</b></label>
                                <select class="form-control" name="id_proof[]" id="id_proof${r}">
                                    <option value="--Select Id Proof--">--Select Id Proof--</option>
                                    <option value="Aadhaar card">Aadhaar Card</option>
                                    <option value="Pan Card">Pan Card</option>
                                </select>
                                <p id="errid_proof" class="mb-0 text-danger em"></p>
                            </div>
                            <div class="form-group pt-3 col-lg-2 col-md-4">
                                <label class="pb-2" for="id_number"><b>Enter Id Card Number*</b></label>
                                <input type="text" class="form-control" name="id_number[]" id="id_number${r}"
                                    placeholder="Enter id card number">
                                <p id="errid_number" class="mb-0 text-danger em"></p>
                            </div>
                            <div class="form-group pt-3 col-lg-2 col-md-4">
                                <label class="pb-2" for="phone"><b>Mobile Number*</b></label>
                                <input type="text" class="form-control" name="phone[]" id="phone${r}" maxlength="10" placeholder="Enter mobile number" onkeypress="return isNumber(event)" autocomplete="true">
                                <p id="errphone" class="mb-0 text-danger em"></p>
                            </div>
                            <div class="form-group pt-3 col-lg-1 col-md-4" style="margin-top:32px">
                                    <button class="btn btn-danger deletebtn" id="removebtn${r}">X</button>
                                </div>
                                </div>`);
                                r++;
                z++;
                $("#removebtn"+r).show();
            } else{
                alert('Please fillup previous fields');
            }
        }else{
            alert("You Can Add Maximum 5 Devotees");
        }

    });

    /* ==========   remove row    ========== */

    $(document).on('click', 'button.deletebtn', function () {
        v=r-1;
        $(this).closest('#removerow'+v).remove();
        r--;
        return false;
    });

    $(document).on('change', 'input[name="booking_date"]', function() {

        $(".request-loader").addClass("show");
        var dateParam = $(this).val();

        $.ajax({
            url: "{{ route('available.slot') }}",
            type: 'GET',
            data: { date: dateParam, slug: 'normal-booking' },
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
