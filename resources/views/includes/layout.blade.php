<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>

    @include('includes.styles')
    @yield('style')
</head>

<body>
    @include('includes.header')

    @section('container')
    @show

    @include('includes.footer')

    @include('includes.scripts')
    @yield('script')

</body>
</html>
