<!-- Modal Details User -->
<div class="modal fade" id="showUserModal" tabindex="-1" aria-labelledby="showUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content rounded-0">
        <div class="modal-header">
          <h5 class="modal-title" id="showUserModalLabel">{{ __('Détails de l\'utilisateur') }}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
        </div>
        <div class="modal-body">
          <div class="text-center mb-3">
            <img id="show-avatar" src="" class="rounded-circle shadow" width="100" height="100" alt="Avatar">
          </div>
          <ul class="list-group">
            <li class="list-group-item"><strong>Pseudo :</strong> <span id="show-pseudo"></span></li>
            <li class="list-group-item"><strong>Email :</strong> <span id="show-email"></span></li>
            <li class="list-group-item"><strong>Contact :</strong> <span id="show-contact"></span></li>
            <li class="list-group-item"><strong>Adresse :</strong> <span id="show-address"></span></li>
            <li class="list-group-item"><strong>Rôle :</strong> <span id="show-role" class="badge"></span></li>
            <li class="list-group-item"><strong>Statut :</strong> <span id="show-status" class="badge"></span></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  