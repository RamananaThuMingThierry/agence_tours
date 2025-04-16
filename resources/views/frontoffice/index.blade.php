@extends('frontoffice.app')

@push('style')
    <style>

        .nav-link:hover {
            color: #ffc107 !important;
        }
        #heroCarousel .hero-slide-img {
            height: 80vh;
            object-fit: cover;
            object-position: center;
        }

        .carousel-caption {
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
        }

        .divider {
            width: 60px;
            height: 4px;
            background-color: #ffc107;
            border-radius: 2px;
        }

        .gallery-item {
            height: 300px;
        }

        .gallery-img {
            object-fit: cover;
            width: 100%;
            height: 100%;
            display: block;
            transition: transform 0.3s ease-in-out;
        }

        .gallery-img:hover {
            transform: scale(1.05);
            border-radius: 2px;
        }

        .tour-card {
            transition: 0.4s ease-in-out;
        }
        .tour-card:hover {
            transform: scale(1.02);
            cursor: pointer;
        }

        #scrollToTopBtn {
            position: fixed;
            bottom: 30px;
            right: 20px;
            display: none;
            z-index: 9999;
            width: 45px;
            height: 45px;
            font-size: 18px;
            justify-content: center;
            align-items: center;
        }

        #scrollToTopBtn:hover {
            background-color: #c82333;
        }

    </style>
@endpush

@section('content')
    @section('title', 'Accueil - World of Madagascar Tour')
    @section('meta_description', 'Explore Madagascar with private tours, local guides, and cultural adventures.')
    @section('meta_keywords', 'Madagascar, Tours, Private guide, Adventure, Culture')

    @include('backoffice.reservations.create')
    @include('frontoffice.slides.index')
    @include('frontoffice.services.index')
    @include('frontoffice.galleries.index')
    @include('frontoffice.about.index')
    @include('frontoffice.tours.index')
    @include('frontoffice.testimonials.index')
    @include('frontoffice.contacts.index')
    @include('frontoffice.layouts.footer')
@endsection
