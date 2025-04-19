<!-- Modal de visualisation -->
<div class="modal fade" id="reservationDetailModal" tabindex="-1" aria-labelledby="reservationDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content shadow-sm rounded-1">
            <div class="modal-header bg-light">
                <h5 class="modal-title" id="reservationDetailModalLabel"><i class="fas fa-info-circle text-danger"></i>&nbsp;{{ __('reservation.reservation_details') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('form.cancel') }}"></button>
            </div>
            <div class="modal-body">
                <ul class="list-group">
                    <li class="list-group-item"><strong>{{ __('form.name') }}:</strong> <span id="res-name"></span></li>
                    <li class="list-group-item"><strong>{{ __('form.email') }}:</strong> <span id="res-email"></span></li>
                    <li class="list-group-item"><strong>{{ __('form.phone') }}:</strong> <span id="res-phone"></span></li>
                    <li class="list-group-item"><strong>{{ __('form.message') }}:</strong> <span id="res-message"></span></li>
                    <li class="list-group-item"><strong>{{ __('form.tour') }}:</strong> <span id="res-tour"></span></li>
                    <li class="list-group-item"><strong>{{ __('form.status') }}:</strong> <span id="res-status"></span></li>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-outline-danger" data-bs-dismiss="modal" aria-label="{{ __('form.cancel') }}"><i class="fas fa-arrow-left"></i>&nbsp;{{ __('form.cancel') }}</button>
            </div>
        </div>
    </div>
</div>
