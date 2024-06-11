<div class="lang-div ms-auto text-end d-none" id="mb-lang">
    <label for="lang">{{ __('Language') }}</label>
    <select name="lang" id="lang" onchange="window.location=this.value">
        <option {{ app()->getLocale() != 'en' ? 'value=' . route('lang.set',['lang_locale' => 'en']) : 'selected' }}>@lang('English')</option>
        <option {{ app()->getLocale() != 'or' ? 'value=' . route('lang.set',['lang_locale' => 'or']) : 'selected' }}>@lang('Odia')</option>
    </select>
</div>
<section class="header">
    <div class="top_header">
        <div class="container" id="desk_logo">
            <div class="logo-wrapper d-flex align-items-center">
                <div class="d-logo-wrap d-flex">
                    <div class="logo">
                        <img src="{{ asset('/assets') }}/images/flag.gif" height="75px" alt="">
                    </div>
                    <div class="logo-text">
                        <img src="{{ asset('/assets') }}/images/sjs-new-logo.gif" height="75px" alt="">
                    </div>
                </div>
                <div class="lang-div ms-auto">
                    <label class="text-white" for="lang">{{ __('Language') }}</label>
                    <select name="lang" id="lang" onchange="window.location=this.value">
                        <option {{ app()->getLocale() != 'en' ? 'value=' . route('lang.set',['lang_locale' => 'en']) : 'selected' }}>@lang('English')</option>
                        <option {{ app()->getLocale() != 'or' ? 'value=' . route('lang.set',['lang_locale' => 'or']) : 'selected' }}>@lang('Odia')</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="bottom_header">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light">
                <div class="container-fluid">
                    <a class="navbar-brand d-none mobile_logo" href="#">
                        <div class="logo_wrapper d-flex align-items-center">
                            <div class="logo">
                                <img src="{{ asset('/assets') }}/images/flag.gif" height="75px" alt="">
                            </div>
                            <div class="logo-text">
                                <img src="{{ asset('/assets') }}/images/sjs-new-logo.gif" height="75px" alt="">
                            </div>
                        </div>
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarScroll">
                        <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll"
                            style="--bs-scroll-height: 100px;">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" aria-current="page" href="{{ route('home') }}">@lang('Home')</a>
                            </li>
                            {{-- <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('booking.special') ? 'active' : '' }}" href="{{ route('booking.special') }}">@lang('Special Darshan')</a>
                            </li> --}}
                            {{-- <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('booking') ? 'active' : '' }}" href="{{ route('booking') }}">@lang('Darshan')</a>
                            </li> --}}
                            @if (auth()->check() && !in_array(auth()->user()?->role->role_name, ['Super Admin','Admin'], true))
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">@lang('Booking History')</a>
                            </li>
                            @endif
                        </ul>
                        @if (auth()->check() && !in_array(auth()->user()?->role->role_name, ['Super Admin','Admin'], true))
                        <a href="{{ route('logout') }}" class="red_btn">
                            @lang('Logout')
                        </a>
                        {{-- @else
                        <a href="{{ route('login') }}" class="red_btn login-btn">
                            @lang('Login') / @lang('Register')
                        </a> --}}
                        @endif
                    </div>
                </div>
            </nav>
        </div>
    </div>
</section>


