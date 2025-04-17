<section id="tours" class="py-5 position-relative" style="background: url('{{ asset(config('public_path.public_path').'images/cameleon.jpg') }}') no-repeat center center / cover;">
    <div class="container position-relative z-2">
        <div class="text-center text-white mb-5">
            <h2 class="fw-bold text-uppercase">{{ __('frontend.our_tours') }}</h2>
            <div class="mx-auto mt-2" style="width: 60px; height: 4px; background-color: #ffc107;"></div>
        </div>

        <div class="row g-4">
            @foreach($tours as $tour)
                @php
                    $shortDesc = Str::limit($tour->description, 120);
                    $isLong = strlen($tour->description) > 120;
                @endphp
                <div class="col-md-4">
                    <div class="card tour-card h-100 border-0 shadow overflow-hidden rounded-4 bg-white position-relative">
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
                            </div>
                        </div>

                        <div class="card-body d-flex flex-column justify-content-between">
                            <div>
                                <h5 class="card-title text-danger text-center text-uppercase fw-bold">{{ $tour->title }}</h5>
                                <div class="mx-auto my-2" style="width: 40px; height: 3px; background-color: #ffc107;"></div>
                                <p class="card-text text-dark" style="text-align: justify;">
                                    {{ $shortDesc }}
                                    @if($isLong)
                                        <span id="moreText{{ $tour->id }}" class="collapse">{{ substr($tour->description, 120) }}</span>
                                        <a class="text-primary toggle-readmore"
                                        data-bs-toggle="collapse"
                                        href="#moreText{{ $tour->id }}"
                                        role="button"
                                        aria-expanded="false"
                                        aria-controls="moreText{{ $tour->id }}"
                                        data-tour-id="{{ $tour->id }}">
                                         {{ __('default.read_more') }}
                                     </a>
                                    @endif
                                </p>
                                <p class="text-danger text-center">{{ __('default.from') }}</p>
                                <p class="text-center"><span class="text-dark fw-bold">{{ $tour->price }}</span>&nbsp;<span class="text-secondary">USD</span></p>
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
