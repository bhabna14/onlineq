@extends('includes.layout')
@section('container')
<section class="banner_section pt-5">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h3 class="form_header text-white">@lang('Welcome to Jagannath Temple Darshan Login portal.')</h3>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-lg-4 col-md-8">
                <div class="banner_form mt-2">
                    <form id="otpForm" action="{{ route('otp.generate') }}" method="POST">
                        @csrf
                        <input type="hidden" name="role_name" value="User">
                        <div class="form_wrapper pt-3">
                            <div class="form-group">
                                <label class="pb-2" for="phone"><b>@lang('Mobile Number')*</b></label>
                                <input type="text" class="form-control" name="phone" placeholder="@lang('Enter mobile number')" onkeypress="return isNumber(event)" maxlength="10">
                                <p id="errphone" class="mb-0 text-danger em"></p>
                            </div>
                            <div class="form-group mt-3">
                                <button type="button" id="submitOtpBtn" class="btn btn-danger btn-red form-control">@lang('Get OTP')</button>
                                {{-- <div class="col otp-text">
                                    @lang('Not registered yet?') <a href="{{ route('guidelines') }}" class="text-secondary pt-2"><b><u>@lang('Register')</u></b></a>
                                </div> --}}
                                <div class="col otp-text">
                                    <p class="text-secondary pt-2"><b>@lang('Login') / @lang('Register')</b></p>
                                </div>
                            </div>

                        </div>
                    </form>

                    <form class="otpForm d-none" action="{{ route('otp.verify') }}" method="POST">
                        @csrf
                        <input type="hidden" name="role_name" value="">
                        <input type="hidden" name="phone" value="">
                        <div class="form_wrapper pt-3">
                            <div class="form-group">
                                <label class="pb-2" for="mobile"><b>@lang('Enter OTP')*</b></label>
                                <input type="text" class="form-control" name="otp" placeholder="@lang('Enter OTP')" onkeypress="return isNumber(event)" maxlength="6">
                                <div class="col otp-text">
                                    <a href="#" class="text-secondary pt-2 resend-otp"><b><u>@lang('Resend OTP')</u></b></a>
                                </div>
                            </div>
                            <div class="form-group mt-3">
                                <button type="button" class="btn btn-danger btn-red form-control submitOtpBtn">@lang('Submit')</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('script')
<script>


        function login(){
            alert('Please Login First');
            location.href = '{{ route('login') }}';
        }

    function isNumber(evt) {
        var iKeyCode = (evt.which) ? evt.which : evt.keyCode
        if (iKeyCode != 46 && iKeyCode > 31 && (iKeyCode < 48 || iKeyCode > 57)) {
            toastr.info("@lang('Please enter only numeric value.')");
            return false;
        } else {
            return true;
        }
    }

    $(document).on('click','.resend-otp',function() {
        $(".em").each(function () {
            $(this).html("");
        });
        $("#submitOtpBtn").click();
    });

    function enterOtp(data){
        $(".em").each(function () {
            $(this).html("");
        });
        toastr.success(`@lang('OTP sent to') ${data.phone}`, {timeOut: 2500});
        var $this = $('.otpForm');
        $this.find('input[name=phone]').val(data.phone);
        $this.find('input[name=role_name]').val(data.role_name);
        $this.removeClass('d-none').prev('form').addClass('d-none');
    }

    /* ***************************************************************
        ==========disabling default behave of form submits start==========
        *****************************************************************/

        $("#otpForm").attr("onsubmit", "return false");
        $(document.getElementsByClassName("otpForm")).attr("onsubmit", "return false");

        /* *************************************************************
        ==========disabling default behave of form submits end==========
        ***************************************************************/

        /* ***************************************************
        ==========Form Submit with AJAX Request Start==========
        ******************************************************/

        $(document).on("click", ".submitOtpBtn", function (e) {
            $(e.target).attr("disabled", true);

            $(".request-loader").addClass("show");

            let otpForm = $(e.target).parent().closest("form");
            let fd = new FormData(otpForm[0]);
            let url = otpForm.attr("action");
            let method = otpForm.attr("method");

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

                    if (data.status === 'not registered') {
                        location.href = data.url;
                    } else if (data == "success") {
                        location.reload();
                    }

                    // if error occurs
                    else if (typeof data.error != "undefined") {
                        for (let x in data) {
                            if (x == "error") {
                                continue;
                            }
                            otpForm
                                .find("[name='" + x + "']")
                                .after(
                                    `<p class="mb-0 text-danger em">${data[x][0]}</p`
                                );
                        }
                    }
                },
                error: function (error) {
                    $(".em").each(function () {
                        $(this).html("");
                    });
                    for (let x in error.responseJSON.errors) {
                        otpForm
                            .find("[name='" + x + "']")
                            .after(
                                `<p class="mt-0 mb-0 text-danger em">${error.responseJSON.errors[x][0]}</p`
                            );
                    }
                    $(".request-loader").removeClass("show");
                    $(e.target).attr("disabled", false);
                },
            });
        });

        $(document).on("click", "#submitOtpBtn", function (e) {
            $(e.target).attr("disabled", true);
            $(".request-loader").addClass("show");

            let otpForm = document.getElementById("otpForm");
            let fd = new FormData(otpForm);
            let url = $("#otpForm").attr("action");
            let method = $("#otpForm").attr("method");

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

                    if (data == "success") {
                        location.reload();
                    } else if (data.status == 'success' && data.call == 'enterOtp'){
                        enterOtp(data.info);
                    }

                    // if error occurs
                    else if (typeof data.error != "undefined") {
                        for (let x in data) {
                            if (x == "error") {
                                continue;
                            }
                            document.getElementById("err" + x).innerHTML = data[x][0];
                        }
                    }
                },
                error: function (error) {
                    $(".em").each(function () {
                        $(this).html("");
                    });
                    for (let x in error.responseJSON.errors) {
                        document.getElementById("err" + x).innerHTML =
                            error.responseJSON.errors[x][0];
                    }
                    $(".request-loader").removeClass("show");
                    $(e.target).attr("disabled", false);
                },
            });
        });

        /* ***************************************************
        ==========Form Submit with AJAX Request End==========
        ******************************************************/
</script>
@endsection
