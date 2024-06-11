@extends('admin.includes.layout')
@section('container')
<!-- Page header -->
<div class="page-header page-header-light shadow">
    <div class="page-header-content d-lg-flex">
        <div class="d-flex">
            <h4 class="page-title mb-0">
                Dashboard - <span class="fw-normal">Dashboard</span>
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
                <a href="#" class="breadcrumb-item">Dashboard</a>
                <span class="breadcrumb-item active">Dashboard</span>
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
            <h5 class="mb-0">Dashboard</h5>
        </div>

        <div class="card-body">
            <h1>Dashboard</h1>
        </div>
    </div>
    <!-- /sidebars overview -->

</div>
<!-- /content area -->
@endsection
