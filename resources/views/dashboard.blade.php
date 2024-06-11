@extends('includes.layout')
@section('container')
<section class="booking-hostory">
    <div class="container pt-5 pb-5">
        <div class="form-title">
            <div class="row">
                <div class="col-md-8">
                    <h4>@lang('Booking History')</h4>
                    <hr>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead class="text-center">
                    <tr>
                        <th scope="col">@lang('Sl. No')</th>
                        {{-- <th scope="col">Txn ID</th> --}}
                        {{-- <th scope="col">Txn Date</th> --}}
                        <th scope="col">@lang('Booking Type')</th>
                        <th scope="col">@lang('Booking Date')</th>
                        <th scope="col">@lang('Darshan Date')</th>
                        <th scope="col">@lang('Name')</th>
                        <th scope="col">@lang('Mobile Number')</th>
                        <th scope="col">@lang('Age')</th>
                        <th scope="col">@lang('Gender')</th>
                        {{-- <th scope="col">@lang('Booking Price')</th> --}}
                        <th scope="col">@lang('Id Proof')</th>
                        <th scope="col">@lang('Id Number')</th>
                        <th scope="col">@lang('Action')</th>
                        {{-- <th scope="col">Certificate</th> --}}
                        {{-- <th scope="col">Status</th> --}}
                        {{-- <th scope="col">Amount</th> --}}
                        {{-- <th scope="col">Receipt</th> --}}
                    </tr>
                </thead>
                <tbody class="text-center">
                    @if ($details->isEmpty())
                        <h4 class="card-title text-center">@lang('No Booking Found')</h4>
                    @else
                    @foreach ($details as $d)
                        {{-- @php
                            $cdate = date('Y-m-d');
                            $darshan_date = date('Y-m-d',strtotime($d->booking->booking_date));
                        @endphp --}}
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $d->booking->bookingType->booking_type_name }}</td>
                            <td>{{ date('d-m-Y',strtotime($d->created_at)) }}</td>
                            <td>{{ date('d-m-Y',strtotime($d->booking->booking_date)) }}</td>
                            <td>{{ $d->full_name }}</td>
                            <td>{{ $d->phone }}</td>
                            <td>{{ $d->age }}</td>
                            <td>{{ $d->gender }}</td>
                            {{-- <td>{{ $details->booking->bookingType->booking_price }}</td> --}}
                            <td>{{ $d->idProof->id_proof }}</td>
                            <td>{{ $d->id_number }}</td>
                            <td>
                                <a href="{{ route('dashboard.history.view',Crypt::encrypt($d->booking_id)) }}" class="btn btn-primary">View</a>
                                @if(date('Y-m-d') < date('Y-m-d',strtotime($d->booking->booking_date)))
                                    @if ($d->booking->is_cancelled == 0 )
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                        Cancel Booking
                                    </button>
                                    @else
                                        <button class="btn btn-danger">Cancelled</button>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
   </section>

@foreach ($details as $dt)
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('booking.cancel') }}" method="POST" id="ajaxForm">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">@lang('Cancel Booking')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <input type="hidden" name="booking_id" value="{{ Crypt::encrypt($dt->booking_id) }}">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="pb-2" for="phone"><b>@lang('Cancel Reason')*</b></label>
                        <textarea class="form-control" name="cancel_reason" autocomplete="true" cols="30"
                            rows="4"></textarea>
                        <p id="errcancel_reason" class="mb-0 text-danger em"></p>
                    </div>
                </div>
                <div class="modal-footer">
                    {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('Close')</button> --}}
                    <button type="button" class="btn btn-success" id="submitBtn">@lang('Save')</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endforeach
@endsection


