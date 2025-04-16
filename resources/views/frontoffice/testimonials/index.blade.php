<section id="testimonials" class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold text-danger">{{ __('frontend.testimonials') }}</h2>
            <div class="mx-auto mt-2" style="width: 60px; height: 4px; background-color: #ffc107;"></div>
        </div>

        <div class="row g-4">
            @foreach($testimonials as $testimonial)
                @php
                    $shortMsg = Str::limit($testimonial->message, 150);
                    $isLongMsg = strlen($testimonial->message) > 150;
                @endphp
                <div class="col-md-4">
                    <div class="card h-100 border-0 elevation-0 rounded-à p-3">
                        <div class="d-flex align-items-center mb-3">
                            <img src="{{ $testimonial->image ? asset(config('public_path.public_path').'images/testimonials/' . $testimonial->image) : asset('images/empty.png') }}"
                                 class="rounded-circle me-3"
                                 width="60"
                                 height="60"
                                 alt="{{ $testimonial->name }}">
                            <div>
                                <h6 class="mb-0 fw-bold">{{ $testimonial->name }}</h6>
                                <small class="text-muted">
                                    @for ($i = 0; $i < $testimonial->rating; $i++)
                                        <i class="fas fa-star text-warning"></i>
                                    @endfor
                                </small>
                            </div>
                        </div>
                        <p class="card-text text-muted" style="text-align: justify;">
                            <i class="fas fa-quote-left me-2 text-danger"></i>
                            {{ $shortMsg }}
                            @if($isLongMsg)
                                <span id="moreTestimonial{{ $testimonial->id }}" class="collapse">{{ substr($testimonial->message, 150) }}</span>
                                <a class="text-primary toggle-readmore-testimonial"
                                   data-bs-toggle="collapse"
                                   href="#moreTestimonial{{ $testimonial->id }}"
                                   role="button"
                                   aria-expanded="false"
                                   aria-controls="moreTestimonial{{ $testimonial->id }}"
                                   data-testimonial-id="{{ $testimonial->id }}">
                                    Lire la suite
                                </a>
                            @endif
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
