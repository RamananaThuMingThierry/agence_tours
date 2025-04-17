<footer id="mainFooter" class="bg-dark text-light pt-5 pb-3">
    <div class="container">
        <div class="row text-center text-md-start">
            <!-- Contact -->
            <div class="col-md-4 mb-4 text-center">
                <h5 class="text-uppercase fw-bold text-danger">{{ __('frontend.contact') }}</h5>
                <p>
                    <i class="fas fa-phone-alt me-2"></i>
                    <a href="tel:+261380913703" class="text-decoration-none text-light">+261 38 09 137 03</a>
                  </p>

                  <p>
                    <i class="fas fa-envelope me-2"></i>
                    <a href="mailto:worldofmadagascartour@gmail.com" class="text-decoration-none text-light">worldofmadagascartour@gmail.com</a>
                  </p>

            </div>

            <!-- Location -->
            <div class="col-md-4 mb-4 text-center">
                <h5 class="text-uppercase fw-bold text-danger">{{ __('frontend.location') }}</h5>
                <p><i class="fas fa-map-marker-alt me-2"></i> Antananarivo, Madagascar</p>
                <p>Ambavahaditokona, Antananarivo</p>
            </div>

            <!-- Social Media -->
            <div class="col-md-4 mb-4 text-center">
                <h5 class="text-uppercase fw-bold text-danger">{{ __('frontend.contect') }}</h5>
                <div class="d-flex justify-content-center gap-3">
                    <a href="#" class="text-primary fs-5"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="text-warning fs-5"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-light fs-5"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-info fs-5"><i class="fab fa-linkedin-in"></i></a>
                    <a href="#" class="text-danger fs-5"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
        </div>

        <div class="text-center border-top pt-3 mt-3" style="font-size: 14px;">
            &copy; {{ now()->year }} {{ __('default.footer_text') }}
        </div>

        <button id="scrollToTopBtn" class="btn btn-danger shadow rounded-circle">
            <i class="fas fa-arrow-up"></i>
        </button>

    </div>
</footer>
