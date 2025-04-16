<section id="about" class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold text-danger">{{ __('frontend.about') }}</h2>
            <div class="divider mx-auto mt-2 mb-2"></div>
        </div>

        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card bg-dark text-white rounded-4 shadow">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-5 mb-3 mb-md-0 text-center">
                                <img src="{{ asset(config('public_path.public_path').'images/person.jpg') }}"
                                     alt="Ricki Cardo"
                                     class="img-fluid rounded-3 shadow" style="max-height: 500px; object-fit: cover;">
                            </div>
                            <div class="col-md-7">
                                <p class="fw-semibold fst-italic mb-2" id="about_title">{{ __('frontend.about_titre') }}</p>
                                <p class="text-justify" style="text-align: justify;">
                                    {!! __('frontend.about_description') !!}
                                </p>
                                <p style="text-align: justify;">
                                    {{ __('frontend.about_description_2') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
