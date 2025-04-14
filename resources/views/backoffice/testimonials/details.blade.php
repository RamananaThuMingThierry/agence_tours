<!-- Show Testimonial Modal -->
<div class="modal fade" id="showTestimonialModal" tabindex="-1" aria-labelledby="showTestimonialLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-0">
            <div class="modal-header">
                <h5 class="modal-title" id="showTestimonialLabel">{{ __('testimonial.details') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-4 text-center">
                        <img id="testimonial-show-image" src="" alt="Image" class="img-fluid rounded shadow">
                    </div>
                    <div class="col-md-8">
                        <p><strong>{{ __('testimonial.name') }} :</strong> <span id="testimonial-show-name"></span></p>
                        <p><strong>{{ __('testimonial.message') }} :</strong> <span id="testimonial-show-message"></span></p>
                        <p><strong>{{ __('testimonial.rating') }} :</strong> <span id="testimonial-show-rating"></span> ⭐</p>
                        <p><strong>{{ __('testimonial.status') }} :</strong> <span id="testimonial-show-status"></span></p>
                        <p><strong>{{ __('form.created_at') }} :</strong> <span id="testimonial-show-created"></span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
