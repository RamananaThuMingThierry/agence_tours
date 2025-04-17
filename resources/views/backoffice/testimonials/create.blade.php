<!-- Modal création témoignage -->
<div class="modal fade" id="testimonialModal" tabindex="-1" aria-labelledby="testimonialModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form id="testimonialForm" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="testimonialModalLabel">{{ __('testimonial.new') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>

                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="name" class="form-label fw-bold">{{ __('testimonial.name') }}</label>
                            <input type="text" class="form-control" id="name" name="name">
                            <div class="invalid-feedback" id="error-name"></div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="rating" class="form-label fw-bold">{{ __('testimonial.rating') }}</label>
                            <select class="form-select" id="rating" name="rating">
                                @for ($i = 1; $i <= 5; $i++)
                                    <option value="{{ $i }}">{{ $i }} <span class="text-warning">★</span></option>
                                @endfor
                            </select>
                            <div class="invalid-feedback" id="error-rating"></div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="message" class="form-label fw-bold">{{ __('testimonial.message') }}</label>
                            <textarea class="form-control" id="message" name="message" rows="4"></textarea>
                            <div class="invalid-feedback" id="error-message"></div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label fw-bold">{{ __('testimonial.image') }}</label>
                        <input type="file" class="form-control" id="image" name="image">
                        <div class="invalid-feedback" id="error-image"></div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-outline-danger" data-bs-dismiss="modal">
                        <i class="fas fa-arrow-left"></i>&nbsp;{{ __('form.cancel') }}
                    </button>
                    <button type="submit" class="btn btn-sm btn-dark" id="btn-save-testimonial">
                        <span class="spinner-border spinner-border-sm d-none me-1" role="status" aria-hidden="true"></span>
                        <span class="btn-text"><i class="fas fa-save"></i>&nbsp;{{ __('form.save') }}</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
