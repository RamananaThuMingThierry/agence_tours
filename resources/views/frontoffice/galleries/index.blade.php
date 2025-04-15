<section id="gallery" class="py-5">
    <div class="container-fluid">
        <div class="text-center mb-5">
            <h2 class="fw-bold text-uppercase text-danger">{{ __('frontend.gallery') }}</h2>
            <div class="divider mx-auto mt-2 mb-2"></div>
            <p class="text-muted">{{ __('frontend.gallery_text') }}</p>
        </div>

        <div class="row g-3">
            @foreach($galleries->take(9) as $image)
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="gallery-item overflow-hidden rounded-0 shadow-sm">
                        <img src="{{ asset(config('public_path.public_path').'galleries/' . $image->image_url) }}"
                             class="img-fluid w-100 h-100 gallery-img"
                             alt="Gallery image">
                    </div>                    
                </div>
            @endforeach
        </div>
    </div>
</section>
