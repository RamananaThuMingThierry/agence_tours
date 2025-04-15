<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="icon" href="{{ asset(config('public_path.public_path').'utiles/logo.jpg') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset(config('public_path.public_path').'utiles/logo.jpg') }}" type="image/x-icon">
    <meta name="author" content="RAMANANA Thu Ming Thierry" />
    <meta name="description" content="Agence Tours" />
    <title>@yield('titre', __('title.default'))</title>
    @stack('style')
    @include('frontoffice.layouts.style')
</head>
<body>
    @include('frontoffice.layouts.header')

    @yield('content')

    @include('frontoffice.layouts.script')
    @stack('script')
</body>
</html>
