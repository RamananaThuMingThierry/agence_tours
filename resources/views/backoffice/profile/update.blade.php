<!-- Modal Modification Info -->
<div class="modal fade" id="editInfoModal" tabindex="-1" aria-labelledby="editInfoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data" class="modal-content">
        @csrf
        @method('PUT')
        <div class="modal-header">
          <h5 class="modal-title" id="editInfoModalLabel">{{ __('profile.edit_title') }}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('profile.close') }}"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="pseudo" class="form-label">{{ __('profile.pseudo') }}</label>
            <input type="text" name="pseudo" id="pseudo" value="{{ old('pseudo', Auth::user()->pseudo) }}" class="form-control">
          </div>
          <div class="mb-3">
            <label for="contact" class="form-label">{{ __('profile.contact') }}</label>
            <input type="text" name="contact" id="contact" value="{{ old('contact', Auth::user()->contact) }}" class="form-control">
          </div>
          <div class="mb-3">
            <label for="address" class="form-label">{{ __('profile.address') }}</label>
            <textarea name="address" id="address" class="form-control">{{ old('address', Auth::user()->address) }}</textarea>
          </div>
          <div class="mb-3">
            <label for="avatar" class="form-label">{{ __('profile.avatar') }}</label>
            <input type="file" name="avatar" id="avatar" class="form-control">
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-sm btn-primary">
            <i class="fas fa-save"></i> {{ __('profile.save') }}
          </button>
        </div>
      </form>
    </div>
  </div>
