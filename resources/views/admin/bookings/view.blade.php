@extends('admin.includes.layout')
@section('container')

{{-- Booking details window --}}

{{-- download button --}}
@if($history)
<section style="padding-top: 5%; padding-bottom: 5%; box-sizing: border-box; background-color: #f8f9fa;">
    {{-- <div class="download-pdf"
        style="text-align:right; margin-top:20px;max-width: 1000px; margin:auto; margin-bottom:20px;">
        <a href="" class="btn-red">Download PDF</a>
    </div> --}}
    <div
        style="max-width: 1000px; margin: 0 auto; background-color: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
        {{-- @if ($history->isEmpty())
        <h4 class="card-title text-center">@lang('No Booking Found')</h4>
        @else --}}
        <!-- Darshan Info -->
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td colspan="2" style="text-align: center;">
                    <!-- Dummy avatar goes here -->
                    <img src="{{url('/')}}/assets/images/flag.gif" style="height: 100px;" alt="logo">
                    <h3 style="padding-top: 10px; margin: 0; color:#B7070A; font-weight:bold;">Shree Jagannatha</h3>
                    <p style="margin: 0; font-size: 14px;">Tentative time for Darshan: 10.00 AM to 12.00 Noon.</p>
                    <p style="margin: 0; font-size: 14px;">Subject to Rituals time i.e end of Gopal Ballav bhoga to end
                        of Sakal Dhupa Bhoga.</p>
                    <hr style="color:#B7070A;">
                </td>
                <td style="text-align: right;">
                    <img src="{{ url('/') }}/{{ config('app.name') }}/{{ $history->full_image }}"
                        style="height: 150px; border-radius: 8px;">
                </td>
            </tr>
            <tr>
                <th style="text-align: left;font-size:14px;">Booking Date</th>
                <th style="text-align: left;font-size:14px;">Darshan Date</th>
                <th style="text-align: left;font-size:14px;">Darshan type</th>
            </tr>
            <tr>
                <td style="text-align: left; padding: 8px;font-size:14px;">{{
                    date('d-m-Y',strtotime($history->created_at)) }}</td>
                <td style="text-align: left; padding: 8px;font-size:14px;">{{
                    date('d-m-Y',strtotime($history->booking->booking_date)) }}</td>
                <td style="text-align: left; padding: 8px;font-size:14px;">specially Abled Booking</td>
            </tr>
        </table>

        <!-- Devotee Details -->
        <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
            <caption
                style="font-size: 16px; font-weight: bold; margin-bottom: 10px; text-align: left; caption-side: top;color:#B7070A;">
                Devotee Details:</caption>
            <thead>
                <tr>
                    <th style="padding: 8px; text-align: left;font-size:14px;">Devotee Name</th>
                    <th style="padding: 8px; text-align: left;font-size:14px;">Id Proof</th>
                    <th style="padding: 8px; text-align: left;font-size:14px;">Id Number</th>
                    <th style="padding: 8px; text-align: left;font-size:14px;">Age</th>
                    <th style="padding: 8px; text-align: left;font-size:14px;">Gender</th>
                    {{-- <th style="padding: 8px; text-align: left;font-size:14px;">Address</th> --}}
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="padding: 8px;font-size:14px;">{{ $history->full_name }}</td>
                    <td style="padding: 8px;font-size:14px;">{{ $history->idProof->id_proof }}</td>
                    <td style="padding: 8px;font-size:14px;">{{ $history->id_number }}</td>
                    <td style="padding: 8px;font-size:14px;">{{ $history->age }}</td>
                    <td style="padding: 8px;font-size:14px;">{{ $history->gender }}</td>
                    {{-- <td style="padding: 8px;font-size:14px;">{{ $history->address }}</td> --}}
                </tr>
            </tbody>
        </table>

        <!-- Attendant Details -->
        <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
            <caption
                style="font-size: 16px; font-weight: bold; margin-bottom: 10px; text-align: left; caption-side: top;color:#B7070A;">
                Attendant Details:</caption>
            <!-- Attendant 1 -->
            <thead>
                <tr>
                    <th style="padding: 8px; text-align: left;font-size:14px;">Attendant Name</th>
                    <th style="padding: 8px; text-align: left;font-size:14px;">Id Proof</th>
                    <th style="padding: 8px; text-align: left;font-size:14px;">Id Number</th>
                    <th style="padding: 8px; text-align: left;font-size:14px;">Age</th>
                    <th style="padding: 8px; text-align: left;font-size:14px;">Gender</th>
                    {{-- <th style="padding: 8px; text-align: left;font-size:14px;">Address</th> --}}
                </tr>
            </thead>
            <tbody>
                @foreach ($attendant as $attendant)
                <tr>
                    <td style="padding: 8px;font-size:14px;">{{ $attendant->full_name }}</td>
                    <td style="padding: 8px;font-size:14px;">{{ $attendant->idProof->id_proof }}</td>
                    <td style="padding: 8px;font-size:14px;">{{ $attendant->id_number }}</td>
                    <td style="padding: 8px;font-size:14px;">{{ $attendant->age }}</td>
                    <td style="padding: 8px;font-size:14px;">{{ $attendant->gender }}</td>
                    {{-- <td style="padding: 8px;font-size:14px;">32</td> --}}
                    {{-- <td style="padding: 8px;font-size:14px;">Male</td> --}}
                    {{-- <td style="padding: 8px;font-size:14px;">Plot-No. 1164, Lingipur, Bhubaneswar, Odisha, 751003
                    </td> --}}
                </tr>
                @endforeach
            </tbody>
            <!-- Attendant 2 -->
            {{-- <thead>
                <tr>
                    <th style="padding: 8px; text-align: left;font-size:14px;">Attendant Name</th>
                    <th style="padding: 8px; text-align: left;font-size:14px;">Adhaar Id</th>
                    <th style="padding: 8px; text-align: left;font-size:14px;">Age</th>
                    <th style="padding: 8px; text-align: left;font-size:14px;">Gender</th>
                    <th style="padding: 8px; text-align: left;font-size:14px;">Address</th>
                </tr>
            </thead> --}}
            {{-- <tbody>
                <tr>
                    <td style="padding: 8px;font-size:14px;">Rajkishore Behera</td>
                    <td style="padding: 8px;font-size:14px;">8598 7898 7898</td>
                    <td style="padding: 8px;font-size:14px;">32</td>
                    <td style="padding: 8px;font-size:14px;">Male</td>
                    <td style="padding: 8px;font-size:14px;">Plot-No. 1164, Lingipur, Bhubaneswar, Odisha, 751003</td>
                </tr>
            </tbody> --}}
        </table>

        <!-- List of Users -->
        <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
            <caption
                style="font-size: 16px; font-weight: bold; margin-bottom: 10px; text-align: left; caption-side: top;color:#B7070A;">
                Note:</caption>
            <tbody>
                <tr>
                    <td style="padding: 8px; font-size:14px;"> &#9632; &nbsp;The devotee is kindly requested to present
                        a physical copy of the automatically generated darshan booking document.</td>
                </tr>
                <tr>
                    <td style="padding: 8px; font-size:14px;"> &#9632; &nbsp;Following officials of Shree Jagannath
                        Temple Administration may be contacted for any assistance.</td>
                </tr>
            <tbody>
                <tr>
                    <td style="padding: 8px; font-size:14px;padding-left:20px;">1. Shri Jitendra Narayan Mohanty, P.R.O,
                        Mob. No:8763677556</td>
                </tr>
                <tr>
                    <td style="padding: 8px; font-size:14px;padding-left:20px;">2. Shri Muktinath Pratihari, I.O., Mob.
                        No: 9861268887</td>
                </tr>
            </tbody>
            </tbody>
        </table>
        {{-- @endif --}}
    </div>
    {{-- <div class="download-pdf" style="text-align:center; margin-top:20px;">
        <a href="" class="btn-red">Download PDF</a>
    </div> --}}
</section>
@else
<h4>No Booking Found</h4>
@endif

@endsection
