<!-- Show Testimonial Modal -->
<div class="modal fade" id="showTestimonialModal" tabindex="-1" aria-labelledby="showTestimonialLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content rounded-0">
            <div class="modal-header">
                <h5 class="modal-title" id="showTestimonialLabel"><i class="fas fa-info-circle"></i>&nbsp;{{ __('testimonial.details') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-4 text-center">
                        <img id="testimonial-show-image" src="" alt="Image" class="img-fluid rounded">
                    </div>
                    <div class="col-md-8">
                        <p><span class="fw-bold">{{ __('testimonial.name') }} :</span> <span id="testimonial-show-name"></span></p>
                        <p><span class="fw-bold">{{ __('testimonial.message') }} :</span> <span id="testimonial-show-message"></span></p>
                        <p><span class="fw-bold">{{ __('testimonial.rating') }} :</span> <span id="testimonial-show-rating"></span> ⭐</p>
                        <p><span class="fw-bold">{{ __('testimonial.status') }} :</span> <span id="testimonial-show-status"></span></p>
                        <p><span class="fw-bold">{{ __('testimonial.created_at') }} :</span> <span id="testimonial-show-created"></span></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-outline-danger" data-bs-dismiss="modal">
                    <i class="fas fa-arrow-left"></i>&nbsp;{{ __('form.cancel') }}
                </button>
            </div>
        </div>
    </div>
</div>
