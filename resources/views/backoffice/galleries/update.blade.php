<!-- Modal d'édition -->
<div class="modal fade" id="editGalleryModal" tabindex="-1" aria-labelledby="editGalleryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <form id="editGalleryForm">
        @csrf
        @method('PUT')
        <input type="hidden" name="id" id="edit-id">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="editGalleryModalLabel">{{ __('gallery.edit') }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label for="edit-status" class="form-label">{{ __('gallery.status') }}</label>
              <select class="form-select" name="status" id="edit-status">
                <option value="publish">{{ __('gallery.publish') }}</option>
                <option value="archived">{{  __('gallery.archived') }}</option>
              </select>
              <div class="invalid-feedback" id="error-edit-status"></div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('gallery.cancel') }}</button>
            <button type="submit" class="btn btn-primary">Mettre à jour</button>
          </div>
        </div>
      </form>
    </div>
  </div>
  