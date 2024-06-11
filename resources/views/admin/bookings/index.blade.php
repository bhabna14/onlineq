@extends('admin.includes.layout')
@section('container')
<!-- Page header -->
<div class="page-header page-header-light shadow">
    <div class="page-header-content d-lg-flex">
        <div class="d-flex">
            <h4 class="page-title mb-0">
                Bookings
                 {{-- - <span class="fw-normal">Today's Bookings</span> --}}
            </h4>

            <a href="#page_header"
                class="btn btn-light align-self-center collapsed d-lg-none border-transparent rounded-pill p-0 ms-auto"
                data-bs-toggle="collapse">
                <i class="ph-caret-down collapsible-indicator ph-sm m-1"></i>
            </a>
        </div>
    </div>

    <div class="page-header-content d-lg-flex border-top">
        <div class="d-flex">
            <div class="breadcrumb py-2">
                <a href="{{ route('home') }}" class="breadcrumb-item"><i class="ph-house"></i></a>
                <a href="#" class="breadcrumb-item">Bookings</a>
                <span class="breadcrumb-item active">List</span>
            </div>

            <a href="#breadcrumb_elements"
                class="btn btn-light align-self-center collapsed d-lg-none border-transparent rounded-pill p-0 ms-auto"
                data-bs-toggle="collapse">
                <i class="ph-caret-down collapsible-indicator ph-sm m-1"></i>
            </a>
        </div>
    </div>
</div>
<!-- /page header -->


<!-- Content area -->
<div class="content">

    {{-- <!-- Info alert -->
    <div class="alert alert-success alert-dismissible">
        <div class="alert-heading fw-semibold">Collapsed secondary sidebar</div>
        Secondary sidebar has 4 states - default, resized, collapsed and hidden. Collapsed and hidden
        states are sharing the same CSS, the only difference is sidebar toggle button. This example
        demonstrates <code>collapsed</code> state. Click the toggler to expand.
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <!-- /info alert --> --}}


    <!-- Sidebars overview -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Bookings</h5>
        </div>
        <div class="card">
            <form id="ajaxSearch" method="POST">
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="form-group col-lg-3 col-md-4 col-sm-6">
                            <label class="pb-2" for="fromdate"><b>@lang('Darshan From Date')</b></label>
                            <input type="date" class="form-control" name="fromdate" id="fromdate" autocomplete="true">
                        </div>
                        <div class="form-group col-lg-3 col-md-4 col-sm-6">
                            <label class="pb-2" for="todate"><b>@lang('Darshan To Date')</b></label>
                            <input type="date" class="form-control" id="todate" name="todate" autocomplete="true">
                        </div>
                        <div class="form-group col-lg-3 col-md-4 col-sm-6 mt-4">
                            <button type="button" id="btnSearch" class="btn btn-info">Search</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="card-body">
            @if ($booking_details->isEmpty())
                <h4 class="card-title text-center">@lang('No bookings found for today')</h4>
            @else
            <table class="table datatable-save-state">
                <thead>
                    <tr>
                        <th scope="col">Sl. No</th>
                        {{-- <th scope="col">Booking Type</th> --}}
                        <th scope="col">Booking Date</th>
                        <th scope="col">Darshan Date</th>
                        <th scope="col">Name</th>
                        <th scope="col">Mobile Number</th>
                        <th scope="col">Age</th>
                        <th scope="col">Gender</th>
                        {{-- <th scope="col">Booking Price</th> --}}
                        <th scope="col">Id Type</th>
                        <th scope="col">Id Number</th>
                        <th scope="col">Certificate Photo</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody id="showDetails">

                    @foreach ($booking_details as $booking_detail)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            {{-- <td>{{ $booking_detail->booking->bookingType->booking_type_name }}</td> --}}
                            <td>{{ date('d-m-Y',strtotime($booking_detail->created_at)) }}</td>
                            <td>{{ date('d-m-Y',strtotime($booking_detail->booking->booking_date)) }}</td>
                            <td>{{ $booking_detail->full_name }}</td>
                            <td>{{ $booking_detail->phone }}</td>
                            <td>{{ $booking_detail->age }}</td>
                            <td>{{ $booking_detail->gender }}</td>
                            {{-- <td>{{ $booking_detail->booking->bookingType->booking_price }}</td> --}}
                            <td>{{ $booking_detail->idProof->id_proof }}</td>
                            <td>{{ $booking_detail->id_number }}</td>
                            <td>
                                @if ($booking_detail->disable_certificate)
                                    <a target="_blank" href="{{ url('/').'/'.config('app.name').'/'.$booking_detail->disable_certificate }}"><img src="{{ url('/').'/'.config('app.name').'/'.$booking_detail->disable_certificate }}" height="80px" width="100px"></a>
                                @else
                                    NA (attendant)
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.bookings.view',Crypt::encrypt($booking_detail->booking_id)) }}" class="btn btn-primary">View</a>
                                @if($booking_detail->booking->is_cancelled == 1)
                                    <a class="btn btn-danger">Cancelled</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>
    </div>
    <!-- /sidebars overview -->

</div>
<!-- /content area -->
@endsection

@section('script')
<script>
    $(document).on("click", "#btnSearch", function (e) {
        $(e.target).attr("disabled", true);
        $(".request-loader").addClass("show");
        var fdate = $("#fromdate").val();
        var tdate = $("#todate").val();
        $.ajax({
            type:'POST',
            url:"{{ route('admin.bookings.search') }}",
            data:{
                _token: "{{ csrf_token() }}",
                fdate:fdate,
                tdate:tdate
            },
            dataType: "json",
            success:function(res){
                console.log(res.details);
                $(e.target).attr("disabled", false);
                $(".request-loader").removeClass("show");
                var result=``;
                var count = 0;
                var baseUrl = "{{ url('/') }}";
                var appName = "{{ config('app.name') }}";
                for(var i in res.details){
                    count++;
                    result +=`<tr>
                        <td>${count}</td>
                        <td>${res.details[i].booking_date}</td>
                        <td>${res.details[i].darshan_date}</td>
                        <td>${res.details[i].full_name}</td>
                        <td>${res.details[i].phone}</td>
                        <td>${res.details[i].age}</td>
                        <td>${res.details[i].gender}</td>
                        <td>${res.details[i].id_proof}</td>
                        <td>${res.details[i].id_number}</td>`;
                    if(res.details[i].disable_certificate != null){
                        result +=`<td><a target="_blank" href="${baseUrl}/${appName}/${res.details[i].disable_certificate}"><img height="80px" width="100px" src="${baseUrl}/${appName}/${res.details[i].disable_certificate}"></img></a></td>`;
                    }else{
                        result +=`<td>NA (attendant)</td>`;
                    }
                    result +=`<td>
                             <a href='{{route('admin.bookings.view', '')}}/${res.details[i].booking_id}' class="btn btn-primary">View</a>
                         </td>
                        </tr>`;

                }
                $("#showDetails").html(result);
            }
        });
    });
</script>
@endsection
