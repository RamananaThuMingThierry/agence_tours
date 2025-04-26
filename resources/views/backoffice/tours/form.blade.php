@extends('backoffice.admin')

@section('titre', isset($tour->encrypted_id) ? __('tour.edit_tour') : __('tour.add'))

@section('content')
    <div class="row p-2">
        <div class="card rounded-0 shadow-sm bg-white">
            <form id="tourForm" enctype="multipart/form-data">
                <div class="card-header bg-white">
                    <h2 class="text-danger">{{ isset($tour->encrypted_id) ? __('tour.edit_tour') : __('tour.add_tour') }} </h2>
                </div>
                <div class="card-body">
                    @csrf
                    @if(isset($tour->encrypted_id))
                        @method('PUT')
                    @else
                        @method('POST')
                    @endif

                    @if(isset($tour->encrypted_id))
                        <input type="hidden" name="id" id="tour_id" value="{{ $tour->encrypted_id ?? ''}}">
                        <input type="hidden" name="_method" value="PUT">
                    @endif

                    @include('backoffice.widget.input2',[
                        'label' => __('tour.title'),
                        'name'  => 'title',
                        'value' => $tour->title,
                        'error' => 'TitleError'
                    ])

                    <div class="mb-3">
                        <label for="description" class="form-label fw-bold">{{ __('tour.description') }}</label>
                        <textarea class="form-control" id="description" name="description" rows="10">{{ old('description', $tour->description ?? '') }}</textarea>
                        <span class="text-danger error-message" id="DescriptionError"></span>
                    </div>

                    @include('backoffice.widget.input2', [
                        'label' => __('tour.price') . ' USD',
                        'type'  => 'number',
                        'name'  => 'price',
                        'value' => $tour->price,
                        'error' => 'PriceError'
                    ])

                    <div class="mb-3">
                        <label for="status" class="form-label fw-bold">{{ __('tour.status') }}</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="active" {{ isset($tour->encrypted_id) && $tour->status == 'active' ? 'selected' : '' }}>{{ __('tour.published') }}</option>
                            <option value="inactive" {{ isset($tour->encrypted_id) && $tour->status == 'inactive' ? 'selected' : '' }}>{{ __('tour.draft') }}</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="images" class="form-label fw-bold">{{ __('tour.image') }}</label>
                        <input type="file" class="form-control" id="images" name="images[]" multiple>
                        <span class="text-danger error-message" id="ImagesError"></span>

                        <!-- Conteneur pour afficher les images sélectionnées en temps réel -->
                        <div id="selected-images" class="d-flex flex-wrap gap-2 mt-2"></div>

                        @if(isset($tour->encrypted_id) && $tour->images->isNotEmpty())
                            <div class="mt-2">
                                <label class="form-label fw-bold">{{ __('tour.current_image') }} :</label>
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach($tour->images as $image)
                                        <div class="position-relative selected-image-container">
                                            <img src="{{ asset(config('public_path.public_path').'images/tours/' . $image->image) }}" width="80" height="80" class="rounded shadow">
                                            <button type="button" class="btn btn-sm btn-danger btn-delete-image" data-image-id="{{ $image->encrypted_id  }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                    <hr>
                    <div class="modal-footer">
                        <a type="button" class="btn btn-sm rounded-0 btn-outline-danger me-1" href="{{ route('admin.tours.index') }}"><i class="fa fa-arrow-left"></i>&nbsp;{{ __('form.cancel') }}</a>
                        <button type="submit" class="btn btn-sm rounded-0 btn-primary" id="submitBtn">
                            <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true" id="spinner"></span>
                            <span id="btnText">
                                @if(isset($tour->encrypted_id))
                                    <i class="fa fa-edit"></i>&nbsp;{{ __('form.edit') }}
                                @else
                                    <i class="fa fa-add"></i>&nbsp;{{ __('form.add') }}
                                @endif
                            </span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function () {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#tourForm').submit(function (e) {
            e.preventDefault();

            // Activer le spinner
            $('#submitBtn').attr('disabled', true);
            $('#spinner').removeClass('d-none');
            $('#btnText').addClass('d-none');

            let tourId = $('#tour_id').val() || null;
            let formData = new FormData(this);
            let url = tourId
                ? "{{ route('admin.tours.update',':id') }}".replace(':id', tourId)
                : "{{ route('admin.tours.store') }}";

            // Toujours POST, même en cas de mise à jour
            let method = 'POST';

            // Ajouter _method = PUT si c’est une mise à jour
            if (tourId) {
                formData.append('_method', 'PUT');
            }

            $.ajax({
                url: url,
                type: method,
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    if (response.status === 200) {
                        Swal.fire({
                            position: "center",
                            icon: "success",
                            title: "{{ __('form.success') }}",
                            text: response.message,
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            window.location.href = "{{ route('admin.tours.index') }}";
                        });
                    }

                    // Réactiver le bouton et cacher le spinner en cas de succès
                    $('#submitBtn').attr('disabled', false);
                    $('#spinner').addClass('d-none');
                    $('#btnText').removeClass('d-none');
                },
                error: function (xhr) {
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        const errors = xhr.responseJSON.errors;
                        $('#TitleError').html(errors.title ? errors.title[0] : '');
                        $('#DescriptionError').html(errors.description ? errors.description[0] : '');
                        $('#PriceError').html(errors.price ? errors.price[0] : '');
                        $('#ImagesError').html(errors.images ? errors.images[0] : '');
                        if (errors.images) {
                            Swal.fire({
                                title: "{{ __('form.error') }}",
                                text: errors.images[0],
                                icon: 'warning',
                                timer: 2000,
                                showConfirmButton: false
                            });
                        }
                    } else {
                        Swal.fire({
                            title: "{{ __('form.error') }}",
                            text: "{{ __('form.an_error_unknown') }}",
                            icon: 'error',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    }

                    // Réinitialiser le bouton en cas d’erreur
                    $('#submitBtn').attr('disabled', false);
                    $('#spinner').addClass('d-none');
                    $('#btnText').removeClass('d-none');
                }
            });
        });


        $('.btn-delete-image').click(function () {
            let imageId = $(this).data('image-id');
            let url = "{{ route('admin.tour-images.destroy', ':id') }}".replace(':id', imageId);

            Swal.fire({
                title: "{{ __('form.delete_confirm') }}",
                text: "{{ __('form.delete_image_confirm') }}",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "{{ __('form.yes') }}",
                cancelButtonText: "{{ __('form.no') }}"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {
                            _method: 'DELETE',
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (response) {
                            Swal.fire({
                                title: "{{ __('form.delete') }}",
                                text: response.message,
                                icon: "success",
                                confirmButtonColor: "#3085d6"
                            }).then(() => {
                                location.reload(); // Ou actualisation du tableau si datatables
                            });
                        },
                        error: function (xhr) {
                            let message = "{{ __('form.delete_error') }}";
                            let status = xhr.status;

                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                message = xhr.responseJSON.message;
                            }

                            Swal.fire({
                                title: "{{ __('form.error') }}",
                                text: message,
                                icon: status === 422 ? "warning" : "error",
                                confirmButtonColor: "#d33"
                            });
                        }
                    });
                }
            });
        });


        let selectedImagesContainer = $('#selected-images');
        let input = $('#images')[0];
        let dt = new DataTransfer();

        $('#images').on('change', function () {
            let files = this.files;

            if (files.length > 0) {
                $.each(files, function (index, file) {
                    let reader = new FileReader();
                    reader.onload = function (e) {
                        let imageHTML = `
                            <div class="position-relative selected-image-container">
                                <img src="${e.target.result}" width="80" height="80" class="rounded shadow">
                                <button type="button" class="btn btn-sm btn-danger btn-remove-selected" data-name="${file.name}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>`;
                        selectedImagesContainer.append(imageHTML);
                    };
                    reader.readAsDataURL(file);

                    dt.items.add(file); // Ajoute le fichier à la liste
                });

                input.files = dt.files; // Met à jour le champ de fichier
            }
        });

        // Supprimer une image sélectionnée avant l'envoi
        $(document).on('click', '.btn-remove-selected', function () {
            let fileName = $(this).data('name');

            // Nouvelle instance de DataTransfer pour stocker les fichiers restants
            let newDt = new DataTransfer();
            let files = input.files;

            for (let i = 0; i < files.length; i++) {
                if (files[i].name !== fileName) {
                    newDt.items.add(files[i]); // Conserver les fichiers sauf celui supprimé
                }
            }

            input.files = newDt.files; // Mettre à jour le champ input
            dt = newDt; // Met à jour la variable globale
            $(this).parent().remove(); // Supprime l'image du DOM
        });
    });
</script>
@endpush
