<!-- Modal -->
<div class="modal fade" id="galleryModal" tabindex="-1" aria-labelledby="galleryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <form id="galleryForm" enctype="multipart/form-data">
          @csrf
          <div class="modal-content rounded-1">
            <div class="modal-header">
              <h5 class="modal-title" id="galleryModalLabel"><i class="fas fa-image text-danger"></i>&nbsp;{{ __('gallery.add') }}</h5>
              <button type="button" class="btn-close btn-close-danger" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="image_url" class="form-label">{{ __('gallery.image') }}</label>
                    <input type="file" class="form-control" name="image_url" id="image_url">
                    <div class="invalid-feedback" id="error-image"></div>
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">{{ __('gallery.status') }}</label>
                    <select class="form-select" name="status" id="status">
                        <option value="publish">{{ __('gallery.publish') }}</option>
                        <option value="archived">{{ __('gallery.archived') }}</option>
                    </select>
                    <div class="invalid-feedback" id="error-status"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-outline-danger" data-bs-dismiss="modal"><i class="fas fa-arrow-left"></i>&nbsp;{{ __('form.cancel') }}</button>
                <button type="submit" class="btn btn-sm btn-dark" id="btn-save-gallery">
                    <span class="spinner-border spinner-border-sm d-none me-1" role="status" aria-hidden="true"></span>
                    <span class="btn-text"><i class="fas fa-save"></i>&nbsp;{{ __('form.save') }}</span>
                </button>
            </div>
          </div>
      </form>
    </div>
  </div>
