<!-- Modal -->
<div class="modal fade" id="slideModal" tabindex="-1" aria-labelledby="slideModalLabel" aria-hidden="true">
    <div class="modal-dialog rounded-0 modal-lg">
      <form id="slideForm" enctype="multipart/form-data">
        @csrf
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="slideModalLabel">{{ __('slide.new') }}</h5>
            <button type="button" class="btn-close btn-close-danger" data-bs-dismiss="modal" aria-label="Fermer"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label for="title" class="form-label">{{ __('slide.title') }}</label>
              <input type="text" class="form-control" name="title" id="title">
              <div class="invalid-feedback" id="error-title"></div>
            </div>
            <div class="mb-3">
              <label for="subtitle" class="form-label">{{ __('slide.subtitle') }}</label>
              <input type="text" class="form-control" name="subtitle" id="subtitle">
              <div class="invalid-feedback" id="error-subtitle"></div>
            </div>
            <div class="mb-3">
              <label for="description" class="form-label">{{ __('slide.description') }}</label>
              <textarea class="form-control" name="description" id="description" rows="3"></textarea>
              <div class="invalid-feedback" id="error-description"></div>
            </div>
            <div class="mb-3">
              <label for="order" class="form-label">{{ __('slide.order') }}</label>
              <input type="number" class="form-control" min="1" max="4" name="order" id="order" value="1">
              <div class="invalid-feedback" id="error-order"></div>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">{{ __('slide.image') }}</label>
                <input type="file" class="form-control" name="image" id="image">
                <div class="invalid-feedback" id="error-image"></div>
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-sm btn-outline-danger" data-bs-dismiss="modal">
              <i class="fas fa-arrow-left"></i>&nbsp;{{ __('form.cancel') }}
            </button>
            <button type="submit" class="btn btn-sm btn-primary" id="btn-save-slide">
              <span class="spinner-border spinner-border-sm d-none me-1" role="status" aria-hidden="true"></span>
              <span class="btn-text"><i class="fas fa-save"></i>&nbsp;{{ __('form.save') }}</span>
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
