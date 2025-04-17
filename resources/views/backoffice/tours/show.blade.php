@extends('backoffice.admin')

@section('titre', __('tour.details'))

@push('styles')
<style>
    .image-thumbnail.active-image {
        background-color: #ffc10733;
        border-left: 4px solid #ffc107;
    }

    .h-100{
        height: 95% !important;
    }

    .carousel-image {
        width: 100%;
        height: 450px;
        object-fit: cover;
        border-radius: 0.5rem;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    .description-container {
        max-height: 300px;
        overflow-y: auto;
        padding-right: 5px;
    }

    @media (max-width: 768px) {
        .carousel-image {
            height: 250px;
        }

        .image-thumbnail span {
            display: none;
        }
    }
</style>
@endpush

@section('content')
<div class="container my-4">
    <div class="row mb-2">
        <div class="col-12">
            <a href="{{ route('admin.tours.index') }}" class="text-danger"><i class="fas fa-chevron-left"></i>&nbsp;{{ __('default.back') }}</a>
        </div>
    </div>
    <div class="row">
        <!-- Partie gauche : Slider + miniatures -->
        <div class="col-md-7 mb-4">
            <div class="row">
                <!-- Miniatures -->
                <div class="col-md-2 d-none d-md-block">
                    <div class="list-group" id="imageList">
                        @foreach($tour->images as $key => $image)
                            <div class="list-group-item {{ $key == 0 ? 'active-image' : '' }}"
                                data-bs-target="#carouselTour"
                                data-bs-slide-to="{{ $key }}"
                                style="cursor: pointer;">
                                <img src="{{ asset('images/tours/' . $image->image) }}"
                                     class="w-100 rounded shadow-sm"
                                     style="height: 60px; object-fit: cover;">
                                <span class="small d-block mt-1 text-center">#{{ $key + 1 }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Slider -->
                <div class="col-md-10 col-12">
                    <div id="carouselTour" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            @foreach($tour->images as $key => $image)
                                <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                    <img src="{{ asset('images/tours/' . $image->image) }}"
                                         class="carousel-image"
                                         style="height: 500px;"
                                         alt="Image tour">
                                </div>
                            @endforeach
                        </div>

                        @if($tour->images->count() > 1)
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselTour" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon"></span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselTour" data-bs-slide="next">
                                <span class="carousel-control-next-icon"></span>
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Partie droite : Infos actualité -->
        <div class="col-md-5">
            <div class="card shadow-sm border-0 rounded-1 h-100">
                <div class="card-body">
                    <h3 class="fw-bold text-warning">{{ $tour->title }}</h3>
                    <hr>
                    <div class="text-muted">
                        <p class="text-black">{{ __('tour.description') }}</p>
                        <div class="description-container">
                            {!! nl2br(e($tour->description)) !!}
                        </div>
                    </div>                    
                    <p class="my-2"><strong>{{ __('tour.status') }} :</strong>
                        <span class="badge {{ $tour->status === 'actif' ? 'bg-success' : 'bg-danger' }}">
                            {{ ucfirst($tour->status) }}
                        </span>
                    </p>
                    <p class="mb-1"><strong>{{ __('tour.price') }} :</strong> {{ $tour->price }} USD</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const carousel = document.getElementById('carouselTour');
    const thumbnails = document.querySelectorAll('.image-thumbnail');

    carousel.addEventListener('slid.bs.carousel', function (e) {
        thumbnails.forEach((thumb, index) => {
            thumb.classList.remove('active-image');
            if (index === e.to) {
                thumb.classList.add('active-image');
            }
        });
    });
</script>
@endpush
