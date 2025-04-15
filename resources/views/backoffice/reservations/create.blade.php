<!-- Modal -->
<div class="modal fade" id="reservationModal" tabindex="-1" aria-labelledby="reservationModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form id="reservationForm">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="reservationModalLabel"><i class="fas fa-calendar text-danger"></i>&nbsp;{{ __('reservation.add') }}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="tour_id" id="tour_id">
          <div class="row mb-3">
            <div class="col-12">
              <label class="form-label">{{ __('form.name') }}</label>
              <input type="text" class="form-control" name="name" id="name">
              <div class="invalid-feedback" id="error-name"></div>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">{{ __('form.email') }}</label>
                <input type="email" class="form-control" name="email" id="email">
                <div class="invalid-feedback" id="error-email"></div>
            </div>
            <div class="col-md-6">
              <label class="form-label">{{ __('form.phone') }}</label>
              <input type="text" class="form-control" name="phone" id="phone">
              <div class="invalid-feedback" id="error-phone"></div>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-12">
              <label class="form-label">{{ __('form.message') }}</label>
              <textarea class="form-control" name="message" id="message" rows="3" placeholder="Type your message here..."></textarea>
              <div class="invalid-feedback" id="error-message"></div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-sm btn-outline-danger" data-bs-dismiss="modal"><i class="fas fa-arrow-left"></i>&nbsp;{{ __('form.cancel') }}</button>
          <button type="submit" class="btn btn-sm btn-dark" id="btn-save-reservation">
            <span class="spinner-border spinner-border-sm d-none me-1" role="status" aria-hidden="true"></span>
            <span class="btn-text"><i class="fas fa-save"></i>&nbsp;{{ __('form.save') }}</span>
          </button>
        </div>
      </div>
    </form>
  </div>
</div>
