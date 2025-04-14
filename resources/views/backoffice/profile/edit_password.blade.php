<!-- Modal Changement de mot de passe -->
<div class="modal fade" id="editPasswordModal" tabindex="-1" aria-labelledby="editPasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <form action="{{ route('admin.profile.password.update') }}" method="POST" class="modal-content">
        @csrf
        @method('PUT')
        <div class="modal-header">
          <h5 class="modal-title" id="editPasswordModalLabel">{{ __('Changer le mot de passe') }}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
              <label for="current_password" class="form-label">Mot de passe actuel</label>
              <input type="password" name="current_password" class="form-control" required>
          </div>
          <div class="mb-3">
              <label for="new_password" class="form-label">Nouveau mot de passe</label>
              <input type="password" name="new_password" class="form-control" required>
          </div>
          <div class="mb-3">
              <label for="new_password_confirmation" class="form-label">Confirmation</label>
              <input type="password" name="new_password_confirmation" class="form-control" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-sm btn-warning"><i class="fas fa-lock"></i> {{ __('Modifier') }}</button>
        </div>
      </form>
    </div>
  </div>
  