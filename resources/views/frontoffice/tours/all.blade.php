@extends('frontoffice.app')

@push('style')
<style>
    .bg-header {
        background-color: #ffc107;
    }

    .divider {
        width: 60px;
        height: 4px;
        background-color: #ffc107;
        border-radius: 2px;
    }

    .nav-link:hover {
        color: #ffffff !important;
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

    .tour-img {
        transition: 0.4s ease-in-out;
    }

    .tour-card:hover .tour-img {
        filter: blur(2px);
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
</style>
@endpush

@section('content')
    @section('title', 'Accueil - World of Madagascar Tour')
    @section('meta_description', 'Explore Madagascar with private tours, local guides, and cultural adventures.')
    @section('meta_keywords', 'Madagascar, Tours, Private guide, Adventure, Culture')
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
                <div class="col-md-4">
                    <div class="card tour-card h-100 border-0 shadow overflow-hidden rounded-4 bg-white">
                        <div class="tour-image-wrapper position-relative">
                            <div id="carouselTour{{ $tour->id }}" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    @foreach($tour->images as $index => $img)
                                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                        <img src="{{ asset('images/tours/' . $img->image) }}" class="d-block w-100 tour-img"
                                            alt="{{ $tour->title }}" style="height: 250px; object-fit: cover;">
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="card-body d-flex flex-column justify-content-between">
                            <div>
                                <h5 class="card-title text-danger text-center text-uppercase fw-bold">
                                    {{ $tour->title }}
                                </h5>
                                <div class="mx-auto my-2" style="width: 40px; height: 3px; background-color: #ffc107;"></div>
                                <p class="card-text text-dark" style="text-align: justify;">
                                    {{ Str::limit($tour->description, 120) }}
                                </p>
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
@endpush
