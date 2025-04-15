@extends('frontoffice.app')

@push('style')
    <style>
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

        .service-card:hover {
            transform: translateY(-5px);
            transition: 0.3s;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
    </style>
@endpush

@section('content')
    @include('frontoffice.slides.index')
    @include('frontoffice.services.index')
@endsection
