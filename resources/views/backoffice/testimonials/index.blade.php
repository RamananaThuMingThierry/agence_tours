@extends('backoffice.admin')

@section('titre', __('title.testimonials'))

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/v/bs5/jq-3.7.0/dt-2.0.8/b-3.0.2/b-html5-3.0.2/b-print-3.0.2/r-3.0.2/datatables.min.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"/>
@endpush

@section('content')
    @include('backoffice.testimonials.create')
    @include('backoffice.testimonials.show')
    @include('backoffice.testimonials.update')
    @include('backoffice.testimonials.details')

    <div class="row pt-2">
        <div class="col-12 d-flex align-items-center justify-content-between">
            <h2 class="text-primary">@yield('titre')</h2>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-12">
        <div class="card rounded-0 p-3 shadow-sm">
                <div class="table-responsive">
                    <table id="datatables" class="table table-striped table-bordered display w-100">
                        <thead class="table-dark">
                        <th class="text-center" scope="col">{{ __('testimonial.image') }}</th>
                        <th class="text-center" scope="col">{{ __('testimonial.name') }}</th>
                        <th class="text-center" scope="col">{{ __('testimonial.message') }}</th>
                        <th class="text-center" scope="col">{{ __('testimonial.raiting') }}</th>
                        <th class="text-center" scope="col">{{ __('testimonial.status') }}</th>
                        <th class="text-center" scope="col" class="text-center">{{ __('testimonial.actions') }}</th>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/v/bs5/jq-3.7.0/dt-2.0.8/b-3.0.2/b-html5-3.0.2/b-print-3.0.2/r-3.0.2/datatables.min.js"></script>
    <script type="text/javascript">
      $(document).ready(function(){
        var table = $('#datatables').DataTable({
          ajax: "{{ route('admin.testimonials.index') }}",
          processing: false,
          serverSide: false,
          responsive: true,
          columns: [
                { data: 'image', className: 'text-center' },
                { data: 'name', className: 'text-center' },
                { data: 'message', className: 'text-center' },
                { data: 'rating', className: 'text-center' },
                {
                    data: 'status',
                    className: 'text-center',
                    render: function (data) {
                        return data === 'publish'
                            ? '<span class="badge bg-success">{{ __("testimonial.published") }}</span>'
                            : '<span class="badge bg-secondary">{{ __("testimonial.archived") }}</span>';
                    }
                },
                { data: 'action', orderable: false, searchable: false, className: 'text-center' }
            ],
          dom: '<"row"<"col-sm-6"B><"col-sm-6">>' +
            '<"row mt-2"<"col-sm-6"l><"col-sm-6"f>>' +
            '<"row mt-2"<"col-sm-12"t>>' +
            '<"row ps-3 pe-3"<"col-sm-12 col-md-5 pt-2 p-0"i><"d-flex justify-content-center justify-content-md-end col-sm-12 col-md-7 p-0 pt-2"p>>',
            buttons: [
              {
                extend: 'csv',
                exportOptions: {
                  columns: ':not(:last-child)'
                },
                text: '<i class="fas fa-file-csv" title="Exporter en CSV"></i>'
              },
              {
                extend: 'pdfHtml5',
                exportOptions: {
                  columns: ':not(:last-child)'
                },
                text: '<i class="fas fa-file-pdf" title="Exporter en PDF"></i>',
                customize: function(doc) {
                  if (doc.content[1].table.body[0].length === 1) {
                    doc.content[1].table.widths = ['*'];
                  }
                }
              },
              {
                extend: 'print',
                exportOptions: {
                  columns: ':not(:last-child)'
                },
                text: '<i class="fas fa-print" title="Imprimer"></i>'
              },
              {
                text: '<i class="fas fa-sync-alt" title="Actualiser"></i>',
                action: function (e, dt, node, config) {
                  location.reload(); // Recharge la page entière
                }
              }
            ],
            columnDefs: [
              { targets: -1, orderable: false }
            ],
          columnDefs: [
            { targets: -1, orderable: false }
          ],
          language: {
            url: "{{ asset(config('public_path.public_path').'lang/datatables/' . app()->getLocale() . '.json') }}"
          }, initComplete: function() {

            // Function to generate a random color
            function getRandomColor() {
              var letters = '0123456789ABCDEF';
              var color = '#';

              for (var i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
              }

              return color;
            }

            // Apply random colors to buttons
            $('.dt-buttons button').each(function() {
              $(this).css('background-color', getRandomColor());
            });
          }
        });

        // Ajouter le bouton "Actualiser" au DOM
        $('<button id="btn-refresh" class="btn btn-secondary ml-2">Actualiser</button>').appendTo('div.RefreshButton');

        // Recharger le tableau lorsque le bouton "Actualiser" est cliqué
        $('#btn-refresh').click(function() {
          table.ajax.reload(null, false); // Reload the data without resetting pagination
        });
      });

      // Ouvrir la modal au clic sur une image
    $(document).on('click', '.testimonial-image', function () {
        const src = $(this).data('src');
        $('#preview-image').attr('src', src);
        $('#imagePreviewModal').modal('show');
    });

    // Ouvrir la modale d'édition (uniquement pour le statut)
    $(document).on('click', '#btn-edit-testimonial-modal', function () {
        const id = $(this).data('id');
        const status = $(this).data('status');

        $('#edit-testimonial-id').val(id);
        $('#edit-testimonial-status').val(status);
        $('#editTestimonialModal').modal('show');
    });

    // Soumettre le formulaire de mise à jour
    $('#editTestimonialForm').on('submit', function (e) {
        e.preventDefault();

        const id = $('#edit-testimonial-id').val();
        const status = $('#edit-testimonial-status').val();
        const $btn = $('#btn-update-testimonial-status');

        $btn.prop('disabled', true);
        $btn.find('.spinner-border').removeClass('d-none');
        $btn.find('.btn-text').text("{{ __('form.in_progress') }}");

        $.ajax({
            url: `/backoffice/testimonials/${id}`,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                _method: 'PUT',
                status: status
            },
            success: function (res) {
                $('#editTestimonialModal').modal('hide');
                $('#editTestimonialForm')[0].reset();
                $('#datatables').DataTable().ajax.reload(null, false);
                toastr.options.positionClass = 'toast-middle-center';
                toastr.success(res.message);
            },
            error: function (xhr) {
                const err = xhr.responseJSON.errors;
                if (err?.status) {
                    $('#edit-testimonial-status').addClass('is-invalid');
                    $('#error-edit-status').text(err.status[0]);
                }
            },
            complete: function () {
                $btn.prop('disabled', false);
                $btn.find('.spinner-border').addClass('d-none');
                $btn.find('.btn-text').html('<i class="fas fa-save"></i> {{ __("form.save") }}');
            }
        });
    });

    // Suppression d'un témoignage avec SweetAlert2
    $(document).on('click', '#btn-delete-testimonial-confirm', function () {
        const id = $(this).data('id');

        Swal.fire({
            title: '{{ __("alerts.confirm_title") }}',
            text: '{{ __("testimonial.confirm_delete_text") ?? __("alerts.confirm_text") }}',
            icon: 'warning',
            showCancelButton: true,
            customClass: {
                confirmButton: 'btn btn-sm btn-dark',
                cancelButton: 'btn btn-sm btn-danger ms-1'
            },
            buttonsStyling: false,
            confirmButtonText: '{{ __("alerts.confirm_button") }}',
            cancelButtonText: '{{ __("alerts.cancel_button") }}'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/backoffice/testimonials/${id}`,
                    type: 'POST',
                    data: {
                        _method: 'DELETE',
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        $('#datatables').DataTable().ajax.reload(null, false);
                        Swal.fire({
                            icon: 'success',
                            title: '{{ __("alerts.delete") }}',
                            text: response.message,
                            timer: 2000,
                            showConfirmButton: false
                        });
                    },
                    error: function (xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: '{{ __("alerts.error") }}',
                            text: '{{ __("alerts.delete_failed") }}'
                        });
                    }
                });
            }
        });
    });

    // Ouvrir modal show avec détails
    $(document).on('click', '#btn-show-testimonial', function () {
        const id = $(this).data('id');

        $.get(`/backoffice/testimonials/${id}`, function (res) {
            if (res.status) {
                const data = res.data;

                $('#testimonial-show-image').attr('src', data.image);
                $('#testimonial-show-name').text(data.name);
                $('#testimonial-show-message').text(data.message);
                $('#testimonial-show-rating').text(data.rating);
                $('#testimonial-show-created').text(data.created_at);

                let badge = data.status === 'publish'
                    ? '<span class="badge bg-success">{{ __("testimonial.published") }}</span>'
                    : '<span class="badge bg-secondary">{{ __("testimonial.archived") }}</span>';

                $('#testimonial-show-status').html(badge);

                $('#showTestimonialModal').modal('show');
            }
        }).fail(function () {
            Swal.fire({
                icon: 'error',
                title: '{{ __("form.error") }}',
                text: '{{ __("form.load_failed") }}',
            });
        });
    });
    </script>
@endpush
