<section id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
        @foreach ($slides as $index => $slide)
            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                <img src="{{ asset(config('public_path.public_path').'images/slides/' . $slide->image) }}" class="d-block w-100 hero-slide-img" alt="{{ $slide->title }}">
                <div class="carousel-caption d-flex flex-column justify-content-center align-items-center h-100">
                    <div class="text-center p-4 rounded">
                        <h1 class="text-white fw-bold">{{ __('frontend.slide_title') }}</h1>
                        <p class="text-white mb-4">{{ __('frontend.slide_subtitle') }}</p>
                        <a href="{{ route('tours') }}" class="btn btn-danger btn-md text-white" style="font-size: 13px;">
                            <i class="fas fa-map-marked-alt me-2"></i> {{ __('frontend.choose_tour') }}
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
    </button>
</section>
