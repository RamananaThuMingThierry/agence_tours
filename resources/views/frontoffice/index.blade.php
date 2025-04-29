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
            height: 400px;
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

        .custom-tooltip {
            --bs-tooltip-bg: #ffc107;
            --bs-tooltip-color: black;
            font-weight: bold;
        }
    </style>
@endpush

@section('content')
    @section('title', 'World of Madagascar Tour - Circuits Touristiques à Madagascar')
    @section('meta_description', 'Explorez Madagascar grâce à World of Madagascar Tour. Circuits sur mesure, immersion culturelle, aventure authentique.')
    @section('meta_keywords', 'voyage Madagascar, circuit Madagascar, aventure, guide touristique')

    @include('backoffice.reservations.create')
    @include('frontoffice.slides.index')
    @include('frontoffice.services.index')
    @include('frontoffice.galleries.index')
    @include('frontoffice.about.index')
    @include('frontoffice.testimonials.index')
    @include('frontoffice.contacts.index')
    @include('frontoffice.layouts.footer')
@endsection

@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var tourDetailModal = document.getElementById('tourDetailModal');

            tourDetailModal.addEventListener('show.bs.modal', function (event) {
                var button = event.relatedTarget; // Le bouton qui a déclenché le modal
                var title = button.getAttribute('data-tour-title');
                var description = button.getAttribute('data-tour-description');

                var modalTitle = tourDetailModal.querySelector('.modal-title');
                var modalBody = tourDetailModal.querySelector('#tourDetailDescription');

                modalTitle.textContent = title;
                modalBody.innerHTML = description.replace(/\n/g, '<br>'); // Respecte les retours à la ligne
            });
        });
    </script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
    </script>


@endpush
