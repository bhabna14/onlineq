@extends('includes.layout')

@section('container')
<!-- banner section -->
<section class="banner_section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 col-md-8">
                <div class="banner_contents pt-5">
                    <h1 class="banner_title text-white">
                        @lang('Registration for the Darshan of Differently Abled devotees.')
                    </h1>
                    <p class="p-0 m-0 text-white">@lang('The Jagannath Temple committee is delighted to announce the launch of a portal, providing an opportunity for individuals with 100% Locomotor Disability to access darshan (sacred viewing).')</p>
                    <a class="btn btn-danger red_btn mt-2" href="{{ route('login') }}">@lang('Login to book for a Darshan')</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
