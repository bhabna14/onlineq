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
                <span class="breadcrumb-item active">Blocked</span>
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
            <div class="d-flex">
                <h5 class="mb-0">Blocked Dates</h5>
                <button type="button" class="btn btn-primary ms-auto" data-bs-toggle="modal" data-bs-target="#modal_add"><i class="ph-plus ms-2"></i>&nbsp;Add Date</button>
            </div>
        </div>

        <div class="card-body">
            @if ($blocked_dates->isEmpty())
                <h4 class="card-title text-center">@lang('No data found')</h4>
            @else
            <table class="table datatable-save-state">
                <thead>
                    <tr>
                        <th scope="col">Sl. No</th>
                        <th scope="col">Blocked Date</th>
                        <th scope="col">Reason</th>
                        <th scope="col">Status</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($blocked_dates as $blocked_date)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ date('d-m-Y', strtotime($blocked_date->blocked_date)) }}</td>
                            <td>{{ $blocked_date->reason }}</td>
                            <td>
                                <form action="{{ route('admin.bookings.blocked.status') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ Crypt::encrypt($blocked_date->id) }}">
                                    <button type="submit" class="btn btn-sm {{ $blocked_date->is_active == 1 ? 'btn-success' : 'btn-warning'}}" data-toggle="tooltip" title="Click to change status">{{ $blocked_date->is_active == 1 ? 'Active' : 'Inactive'}}</button>
                                </form>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-primary btn-icon dropdown-toggle" data-bs-toggle="dropdown">
                                        <i class="ph-list"></i>
                                    </button>

                                    <div class="dropdown-menu">
                                        <button type="button" class="btn text-center dropdown-item editBtn" data-bs-toggle="modal" data-bs-target="#modal_edit" data-id="{{ Crypt::encrypt($blocked_date->id) }}" data-blocked_date="{{ $blocked_date->blocked_date }}" data-reason="{{ $blocked_date->reason }}"><i class="ph-note-pencil"></i>&nbsp;Edit</button>
                                        <form action="{{ route('admin.bookings.blocked.delete') }}" method="post">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ Crypt::encrypt($blocked_date->id) }}">
                                            <button type="submit" class="btn text-center dropdown-item"><i class="ph-trash"></i>&nbsp;Delete</button>
                                        </form>
                                    </div>
                                </div>
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

{{-- Add Modal --}}
<div id="modal_add" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add date</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form id="ajaxForm" action="{{ route('admin.bookings.blocked.create') }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Blocked Date<span class="text-danger">*</span></label>
                        <input name="blocked_date" type="date" class="form-control" value="" placeholder="dd-mm-yyyy" min="{{ date('Y-m-d') }}">
                        <p id="errblocked_date" class="em mb-0 text-danger"></p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Reason<span class="text-danger">*</span></label>
                        <input name="reason" type="text" class="form-control" value="" placeholder="State the reason">
                        <p id="errreason" class="em mb-0 text-danger"></p>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="submitBtn" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- Add Modal --}}

{{-- Edit Modal --}}
<div id="modal_edit" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit date</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form class="ajaxForm" action="{{ route('admin.bookings.blocked.update') }}" method="post">
                @csrf
                <input id="inid" type="hidden" name="id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Blocked Date<span class="text-danger">*</span></label>
                        <input id="inblocked_date" name="blocked_date" type="date" class="form-control" value="" placeholder="dd-mm-yyyy" min="{{ date('Y-m-d') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Reason<span class="text-danger">*</span></label>
                        <input id="inreason" name="reason" type="text" class="form-control" value="" placeholder="State the reason">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary submitBtn">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- Edit Modal --}}
@endsection
