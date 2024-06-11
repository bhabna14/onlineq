@extends('includes.layout')
@section('container')


<section class="payment-summary-wrapper">
    <div class="container p-5">

       <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="payment-summary-box p-5">
                <div class="form-title pb-3">
                    <div class="row">
                        <div class="col-md-12">
                            <h4>Payment Summary</h4>
                            <hr>
                        </div>
                    </div>
                </div>
                <table class="table payment-table">
                    <tbody>
                        <tr>
                            <th scope="row">Devotee Name</th>
                            <td>Demo Test</td>
                        </tr>
                        <tr>
                            <th scope="row">Service Type</th>
                            <td>Paid Darshan</td>
                        </tr>
                        <tr>
                            <th scope="row">Total Number of Devotees</th>
                            <td>1</td>
                        </tr>
                        <tr>
                            <th scope="row">Amount per Devotee</th>
                            <td>100</td>
                        </tr>
                        <tr>
                            <th scope="row">Total Amount</th>
                            <td>100</td>
                        </tr>
                    </tbody>
                </table>
                <div class="paynow-btn text-center mt-5">
                    <a id="payNow" class="btn btn-success">Pay Now</a>
                </div>
            </div>
        </div>
       </div>
    </div>
</section>

@endsection

@section('script')
<script>
    $(document).on("click", "#payNow", function (e) {
        toastr.success('Payment Successful');
        setInterval(dashboard, 4000);
    });
    function dashboard(){
        location.href = "{{ route('dashboard') }}";
    }
</script>
@endsection
