<!-- Edit Testimonial Status Modal -->
<div class="modal fade" id="editTestimonialModal" tabindex="-1" aria-labelledby="editTestimonialLabel" aria-hidden="true">
    <div class="modal-dialog">
      <form id="editTestimonialForm">
        @csrf
        <input type="hidden" id="edit-testimonial-id">
        <div class="modal-content rounded-1">
          <div class="modal-header">
            <h5 class="modal-title" id="editTestimonialLabel"><i class="fas fa-edit"></i>&nbsp;{{ __('testimonial.update_status') }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
          </div>
          <div class="modal-body">
            <label class="form-label">{{ __('testimonial.status') }}</label>
            <select class="form-select" name="status" id="edit-testimonial-status">
              <option value="publish">{{ __('testimonial.published') }}</option>
              <option value="archived">{{ __('testimonial.archived') }}</option>
            </select>
            <div class="invalid-feedback" id="error-edit-status"></div>
          </div>
          <div class="modal-footer">
            <button type="submit" id="btn-update-testimonial-status" class="btn btn-sm btn-dark">
              <span class="spinner-border spinner-border-sm d-none me-1" role="status"></span>
              <span class="btn-text"><i class="fas fa-save"></i> {{ __('form.save') }}</span>
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
