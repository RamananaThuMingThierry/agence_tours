<!-- Modal global pour afficher le détail d'un tour -->
<div class="modal fade" id="tourDetailModal" tabindex="-1" aria-labelledby="tourDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl rounded-1" id="tourDetailModalDialog">
        <div class="modal-content rounded-1">
            <div class="modal-header">
                <h5 class="modal-title text-danger" id="tourDetailModalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('form.cancel') }}"></button>
            </div>
            <div class="modal-body" style="max-height: 450px; overflow-y: auto;">
                <p id="tourDetailDescription" style="text-align: justify;"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-outline-danger" data-bs-dismiss="modal">
                    <i class="fas fa-arrow-left"></i>&nbsp;{{ __('form.cancel') }}
                </button>
            </div>
        </div>
    </div>
</div>
