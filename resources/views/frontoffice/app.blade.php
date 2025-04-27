<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <title>@yield('title', 'World of Madagascar Tour - Circuits et Voyages à Madagascar')</title>

    <link rel="icon" href="{{ asset(config('public_path.public_path').'utiles/icon.png') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset(config('public_path.public_path').'utiles/icon.png') }}" type="image/x-icon">

    <meta name="description" content="@yield('meta_description', 'Découvrez Madagascar autrement avec World of Madagascar Tour : circuits touristiques sur mesure, aventures inoubliables, culture authentique.')">
    <meta name="keywords" content="@yield('meta_keywords', 'voyage Madagascar, circuit Madagascar, tour guide Madagascar, nature, culture, tourisme')">
    <meta name="author" content="RAMANANA Thu Ming Thierry" />

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', 'World of Madagascar Tour - Circuits et Voyages à Madagascar')">
    <meta property="og:description" content="@yield('meta_description', 'Découvrez Madagascar autrement avec World of Madagascar Tour.')">
    <meta property="og:image" content="{{ asset(config('public_path.public_path').'images/facebook.png') }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:title" content="@yield('title', 'World of Madagascar Tour - Circuits et Voyages à Madagascar')">
    <meta property="twitter:description" content="@yield('meta_description', 'Découvrez Madagascar autrement avec World of Madagascar Tour.')">
    <meta property="twitter:image" content="{{ asset(config('public_path.public_path').'images/twitter.png') }}">

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
