<!-- Modal Update -->
<div class="modal fade" id="editSlideModal" tabindex="-1" aria-labelledby="editSlideModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <form id="editSlideForm" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" id="edit-id">
        <input type="hidden" name="_method" value="PUT">

        <div class="modal-content rounded-1">
          <div class="modal-header">
            <h5 class="modal-title" id="editSlideModalLabel">{{ __('slide.edit') }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
          </div>
          <div class="modal-body">

            <div class="mb-3">
              <label for="edit-title" class="form-label">{{ __('slide.title') }}</label>
              <input type="text" class="form-control" id="edit-title" name="title">
              <div class="invalid-feedback" id="error-edit-title"></div>
            </div>

            <div class="mb-3">
              <label for="edit-subtitle" class="form-label">{{ __('slide.subtitle') }}</label>
              <input type="text" class="form-control" id="edit-subtitle" name="subtitle">
              <div class="invalid-feedback" id="error-edit-subtitle"></div>
            </div>

            <div class="mb-3">
              <label for="edit-description" class="form-label">{{ __('slide.description') }}</label>
              <textarea class="form-control" id="edit-description" name="description"></textarea>
              <div class="invalid-feedback" id="error-edit-description"></div>
            </div>

            <div class="mb-3">
              <label for="edit-order" class="form-label">{{ __('slide.order') }}</label>
              <input type="number" class="form-control" id="edit-order" name="order">
              <div class="invalid-feedback" id="error-edit-order"></div>
            </div>

            <div class="mb-3">
              <label for="edit-image" class="form-label">{{ __('slide.image') }}</label>
              <input type="file" class="form-control" id="edit-image" name="image">
              <div class="invalid-feedback" id="error-edit-image"></div>
            </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-sm btn-outline-danger" data-bs-dismiss="modal">
              <i class="fas fa-arrow-left"></i> {{ __('form.cancel') }}
            </button>
            <button type="submit" class="btn btn-sm btn-dark" id="btn-update-slide">
              <span class="spinner-border spinner-border-sm d-none me-1" role="status" aria-hidden="true"></span>
              <span class="btn-text"><i class="fas fa-save"></i>&nbsp;{{ __('form.save') }}</span>
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
