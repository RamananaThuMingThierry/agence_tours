@extends('frontoffice.app')

@push('style')
    <style>
        .bg-header {
            background-color: #fff;
        }

        .divider {
            width: 60px;
            height: 4px;
            background-color: #ffc107;
            border-radius: 2px;
        }

        .nav-link:hover {
            color: #ffc107 !important;
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

        .tour-card {
            position: relative;
            z-index: 2;
        }

        .section-overlay {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1;
        }

        #tours {
            margin-top: 60px !important;
            background: url('{{ asset(config('public_path.public_path').'images/cameleon.jpg') }}') no-repeat center center / cover;
            position: relative;
            z-index: 0;
            min-height:100vh;
        }

        @media (max-width: 991.98px) {
            .nav-link:hover {
                color: #ffffff !important;
            }
        }
    </style>
@endpush

@section('content')
    @section('title', 'Accueil - World of Madagascar Tour')
    @section('meta_description', 'Explore Madagascar with private tours, local guides, and cultural adventures.')
    @section('meta_keywords', 'Madagascar, Tours, Private guide, Adventure, Culture')
    @include('frontoffice.tours.modal')
    @include('backoffice.reservations.create')
    <section id="tours" class="py-5 text-white position-relative">
        <div class="section-overlay"></div>
        <div class="container position-relative z-2">
            <div class="text-center mb-5">
                <h2 class="fw-bold text-uppercase">{{ __('frontend.our_tours') }}</h2>
                <div class="divider mx-auto"></div>
            </div>

            <div class="row g-4">
                @foreach($tours as $tour)
                    @php
                        $shortDesc = Str::limit($tour->description, 120);
                        $isLong = strlen($tour->description) > 120;
                    @endphp
                    <div class="col-md-4">
                        <div class="card tour-card h-100 border-0 shadow overflow-hidden rounded-4 bg-white">
                            <div class="tour-image-wrapper position-relative">
                                <div id="carouselTour{{ $tour->id }}" class="carousel slide" data-bs-ride="carousel">
                                    <div class="carousel-inner">
                                        @foreach($tour->images as $index => $img)
                                            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                                <img src="{{ asset(config('public_path.public_path').'images/tours/' . $img->image) }}"
                                                     class="d-block w-100 tour-img"
                                                     alt="{{ $tour->title }}"
                                                     style="height: 250px; object-fit: cover;">
                                            </div>
                                        @endforeach
                                    </div>

                                    <!-- BOUTONS CONTROLES -->
                                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselTour{{ $tour->id }}" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>

                                    <button class="carousel-control-next" type="button" data-bs-target="#carouselTour{{ $tour->id }}" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                </div>
                            </div>

                            <div class="card-body d-flex flex-column justify-content-between">
                                <div>
                                    <h5 class="card-title text-danger text-center text-uppercase fw-bold">
                                        {{ $tour->title }}
                                    </h5>
                                    <div class="mx-auto my-2" style="width: 40px; height: 3px; background-color: #ffc107;"></div>
                                    <p class="card-text text-dark" style="text-align: justify;">
                                        {{ $shortDesc }}
                                        @if($isLong)
                                            <span id="moreText{{ $tour->id }}" class="collapse">{{ substr($tour->description, 120) }}</span>
                                            <a class="text-primary toggle-readmore"
                                                href="javascript:void(0);"
                                                role="button"
                                                data-bs-toggle="modal"
                                                data-bs-target="#tourDetailModal"
                                                data-tour-title="{{ $tour->title }}"
                                                data-tour-description="{{ $tour->description }}">
                                                {{ __('default.read_more') }}
                                            </a>
                                        @endif
                                    </p>
                                    <p class="text-danger text-center">{{ __('default.from') }}</p>
                                    <p class="text-center"><span class="text-dark fw-bold">{{ number_format($tour->price, 0, '.', ' ') }}</span>&nbsp;<span class="text-secondary">USD</span></p>
                                </div>
                                <a href="javascript:void(0);"
                                    class="btn btn-danger text-white mt-3 w-100"
                                    data-bs-toggle="modal"
                                    data-bs-target="#reservationModal"
                                    data-tour-id="{{ $tour->id }}">
                                        <i class="fas fa-calendar-alt"></i> {{ __('frontend.reserved') }}
                                    </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @include('frontoffice.layouts.footer')
@endsection

@push('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
            var tourDetailModal = document.getElementById('tourDetailModal');
            var modalDialog = document.getElementById('tourDetailModalDialog');

            tourDetailModal.addEventListener('show.bs.modal', function () {
                if (window.innerWidth >= 768) {
                    modalDialog.classList.add('modal-dialog-centered');
                } else {
                    modalDialog.classList.remove('modal-dialog-centered');
                }
            });

            // Optionnel: Si tu veux aussi gérer le resize pendant que le modal est ouvert
            window.addEventListener('resize', function() {
                if (tourDetailModal.classList.contains('show')) {
                    if (window.innerWidth >= 768) {
                        modalDialog.classList.add('modal-dialog-centered');
                    } else {
                        modalDialog.classList.remove('modal-dialog-centered');
                    }
                }
            });
        });
    </script>

@endpush
