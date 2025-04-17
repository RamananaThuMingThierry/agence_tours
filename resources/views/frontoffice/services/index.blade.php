<section id="services" class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold text-danger text-uppercase">{{ __('frontend.services') }}</h2>
            <div class="divider mx-auto mt-2 mb-2"></div>
        </div>

        <div class="row g-4">
            <!-- Service 1 -->
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 elevation-0 bg-light border-0 text-center p-4 service-card">
                    <div class="mb-3">
                        <img src="{{ asset(config('public_path.public_path').'images/services/jumelles.png') }}" alt="Guided Tours" width="80" height="80">
                    </div>
                    <h5 class="fw-bold text-danger text-uppercase mb-2">{{ __('frontend.small_groupes') }}</h5>
                    <p class="text-muted small">{{ __('default.service_jumelle') }}</p>
                </div>
            </div>

            <!-- Service 2 -->
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 elevation-0 bg-light border-0 text-center p-4 service-card">
                    <div class="mb-3">
                        <img src="{{ asset(config('public_path.public_path').'images/services/panneaux.png') }}" alt="Guided Tours" width="80" height="80">
                    </div>
                    <h5 class="fw-bold text-danger text-uppercase mb-2">{{ __('frontend.activity_tours') }}</h5>
                    <p class="text-muted small">{{ __('default.service_panneaux') }}</p>
                </div>
            </div>

            <!-- Service 3 -->
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 elevation-0 bg-light border-0 text-center p-4 service-card">
                    <div class="mb-3">
                        <img src="{{ asset(config('public_path.public_path').'images/services/cible.png') }}" alt="Guided Tours" width="80" height="80">
                    </div>
                    <h5 class="fw-bold text-danger text-uppercase mb-2">{{ __('frontend.highlights') }}</h5>
                    <p class="text-muted small">{{ __('default.service_cible') }}</p>
                </div>
            </div>

            <!-- Service 4 -->
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 elevation-0 bg-light border-0 text-center p-4 service-card">
                    <div class="mb-3">
                        <img src="{{ asset(config('public_path.public_path').'images/services/montre.png') }}" alt="Guided Tours" width="80" height="80">
                    </div>
                    <h5 class="fw-bold text-danger text-uppercase mb-2">{{ __('frontend.custom_tours') }}</h5>
                    <p class="text-muted small">{{ __('default.service_montre') }}</p>
                </div>
            </div>
        </div>
    </div>
</section>
