<!-- Modal Show Slide -->
<div class="modal fade" id="showSlideModal" tabindex="-1" aria-labelledby="showSlideModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content rounded-1">
            <div class="modal-header">
                <h5 class="modal-title" id="showSlideModalLabel"><i class="fas fa-info-circle text-danger"></i>&nbsp;{{ __('slide.details') }}</h5>
                <button type="button" class="btn-close btn-close-red" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-4 text-center">
                        <img id="show-slide-image" src="" class="img-fluid rounded shadow" alt="Slide image">
                    </div>
                    <div class="col-md-8">
                        <div>
                            <span class="fw-bold">{{ __('slide.title') }}:</span><br>
                            <span class="text-muted" id="show-slide-title"></span>
                        </div>
                        <div>
                            <span class="fw-bold">{{ __('slide.subtitle') }}:</span><br>
                            <span class="text-muted" id="show-slide-subtitle"></span>
                        </div>
                        <div>
                            <span class="fw-bold">{{ __('slide.description') }}:</span><br>
                            <span class="text-muted" id="show-slide-description"></span>
                        </div>
                        <div>
                            <span class="fw-bold">{{ __('slide.order') }}:</span>
                            <span class="text-muted" id="show-slide-order"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-outline-danger" data-bs-dismiss="modal" aria-label="Fermer"><i class="fas fa-arrow-left"></i>&nbsp;{{ __('form.cancel') }}</button>
            </div>
        </div>
    </div>
</div>
