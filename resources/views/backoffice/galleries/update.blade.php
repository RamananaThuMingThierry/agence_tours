<!-- Modal de modification du statut -->
<div class="modal fade" id="editGalleryModal" tabindex="-1" aria-labelledby="editGalleryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <form id="editGalleryForm">
        @csrf
        @method('PUT')
        <input type="hidden" id="edit-id" name="id">
        <div class="modal-content rounded-1">
          <div class="modal-header">
            <h5 class="modal-title">{{ __('gallery.update_status') }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label for="edit-status">{{ __('gallery.status') }}</label>
              <select name="status" id="edit-status" class="form-select">
                <option value="publish">{{ __('gallery.publish') }}</option>
                <option value="archived">{{  __('gallery.archived') }}</option>
              </select>
              <div class="invalid-feedback" id="error-edit-status"></div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-sm btn-dark" id="btn-update-status">
                <span class="spinner-border spinner-border-sm d-none me-1" role="status" aria-hidden="true"></span>
                <span class="btn-text"><i class="fas fa-save"></i>&nbsp;{{ __('form.save') }}</span>
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
