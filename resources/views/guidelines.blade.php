@extends('includes.layout')
@section('container')
<section class="modalities pt-5 pb-5">
    <div class="container">
        <div class="form-title">
            <div class="row">
                <div class="col-md-8">
                    <h4>@lang('Guidelines for Darshan of PWD Devotees.')</h4>
                    <hr>
                </div>
            </div>
        </div>
        <div class="modalities-wrapper">
            <ul class="list-group list-group-flush">
                <li class="pt-2 list-group-item"><b>@lang('1.')</b>	@lang('All the Devotees coming under Locomotor Disability will be covered under this facility.')</li>
                <li class="pt-2 list-group-item"><b>@lang('2.')</b>	@lang('This service is completely free of cost.')</li>
                <li class="pt-2 list-group-item"><b>@lang('3.')</b>	@lang('The PWD devotees/pilgrims may take this advantage maximum once in every two month and the devotee will register his name through online at least 5 days before from the date of his/her Darshan.')</li>
                <li class="pt-2 list-group-item"><b>@lang('4.')</b> @lang('The concerned devotee will upload the authenticate disable certificate along with one full body photograph and Aadhar Card/Electoral ‘I’card ,during the time of online registration.')</li>
                <li class="pt-2 list-group-item"><b>@lang('5.')</b>	@lang('The disable devotee along with his/her attendants will report for the service at the Senior Citizen/Divyanga Help Desk center situated near SJTA Office within 9.00 AM to 10.00AM.')</li>
                <li class="pt-2 list-group-item"><b>@lang('6.')</b> @lang('Original Aadhar Card/Electoral ‘I’card will be produced by the devotee during the time of verification.')</li>
                <li class="pt-2 list-group-item"><b>@lang('7.')</b> @lang('Verification of documents & physical check of disabled person will be made at checking centre near Temple Office. If the information furnished by the devotee found incorrect during the verification by the checking team, then he/she will be debarred from getting the privilege of Darshan.')</li>
                <li class="pt-2 list-group-item"><b>@lang('8.')</b> @lang('Physical checking team will verify the person and recommend the case to allow them to proceed to North gate for Darshan of Mahaprabhu. Thereafter, they will come to North Gate of Temple through wheel chair by volunteers.')</li>
                <li class="pt-2 list-group-item"><b>@lang('9.')</b> @lang('There is one rest shed situated near North Gate where the disabled persons will take rest on arrival. Basic facilities like drinking water, urinal and sitting arrangement are available in the rest shed.')</li>
                <li class="pt-2 list-group-item"><b>@lang('10.')</b> @lang('A team of volunteers will be available at rest shed with specially designed carrier.')</li>
                {{-- <li class="pt-2 list-group-item"><b>@lang('11.')</b> @lang('The PWD devotee will sit on the wooden carrier and two volunteers will carry it from North Gate  through Bahar Gumuta via Ghanti Dwar to Jay Bijay Dwar.')</li>
                <li class="pt-2 list-group-item"><b>@lang('12.')</b> @lang('The PWD devotee will sit on the wooden carrier and two volunteers will carry it from North Gate through Bahar Gumuta via Ghanti Dwar to Jay Bijay Dwar.')</li> --}}
                <li class="pt-2 list-group-item"><b>@lang('11.')</b> @lang('The time of Darshan will be made available only in between end of Gopal Ballav Bhoga to end of Sakal Dhupa Bhoga (10 AM to 12 Noon approx). The exact time will be indicated before one hour of Darshan. It will be actual as per rituals of that day.')</li>
                <li class="pt-2 list-group-item"><b>@lang('12.')</b> @lang('One attendant/required persons only shall accompany the PWD devotee during Darshan.')</li>
                <li class="pt-2 list-group-item"><b>@lang('13.')</b> @lang('These facilities will be made for Darshan of Mahaprabhu only and Darshan of other subsidiary shrines will not be taken care of by the volunteers.')</li>
                {{-- <li class="pt-2 list-group-item"><b>@lang('16.')</b> @lang('Maximum 20 disable devotees will be allowed per day for the privileged Darshan.')</li> --}}
                <li class="pt-2 list-group-item"><b>@lang('14.')</b> @lang('This privilege Darshan will not be available on special/major festival days.') </li>
                <li class="pt-2 list-group-item"><b>@lang('15.')</b> @lang('Only Hindu devotees are allowed to avail this darshan facility.') </li>
                {{-- <li class="pt-2 list-group-item"><b>@lang('18.')</b>	@lang('It is very sensitive time, dedicated Dwara Ghara Pratihari and Gochhikar Palia Sevak will facilitate the Darshan of the PWD devotees.')</li> --}}
            </ul>
            <div class="form-title pt-5">
                <div class="row">
                    <div class="col-md-8">
                        <h4>@lang('Undertaking')</h4>
                        <hr>
                    </div>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="check" value="undertaking">
                    <label class="form-check-label" for="">  @lang('I, do hereby undertake that the information furnished above for the purpose of Shree Jagnnath Darshan are true to the best of my knowledge and belief and I declare that I will be debarred from getting the privileged Darshan of Lord Jagannath in case the information so furnished by me are found incorrect.')</label>
                  </div>

                  <div class="modalities-btn-group mt-3">
                    <a href="{{ route('login') }}" class="btn btn-secondary"><i class="fa-solid fa-arrow-left"></i> &nbsp;&nbsp;@lang('Go Back')</a>
                    <button class="btn btn-success" id="proceedBtn">@lang('Proceed to Register') &nbsp;&nbsp;<i class="fa-solid fa-arrow-right"></i></button>
                  </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('script')
    <script>
        $("#proceedBtn").click(function(){
            location.href = "{{ route('register') }}";
        })
    </script>
@endsection
