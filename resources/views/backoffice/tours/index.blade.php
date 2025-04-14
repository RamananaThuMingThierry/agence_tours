@extends('backoffice.admin')

@section('titre', __('sidebar.tour'))

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/v/bs5/jq-3.7.0/dt-2.0.8/b-3.0.2/b-html5-3.0.2/b-print-3.0.2/r-3.0.2/datatables.min.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"/>
@endpush

@section('content')
    <div class="row py-2">
        <div class="col-12 d-flex align-items-center justify-content-between">
            <h2 class="text-primary">@yield('titre')</h2>
            <a class="btn btn-sm btn-success shadow-sm d-flex align-items-center" href="{{ route('admin.tours.create') }}">
                <i class="fas fa-plus p-1 text-white-50"></i>
                <span class="d-none d-sm-inline">&nbsp;{{ __('tour.add') }}</span>
            </a>
        </div>
</div>
    <div class="row mb-2">
        <div class="col-12">
        <div class="card rounded-0 p-3 shadow-sm">
                <div class="table-responsive">
                    <table id="datatables" class="table table-striped table-bordered display w-100">
                        <thead class="table-dark">
                        <th class="text-center" scope="col">{{ __('tour.image') }}</th>
                        <th class="text-center" scope="col">{{ __('tour.title') }}</th>
                        <th class="text-center" scope="col">{{ __('tour.description') }}</th>
                        <th class="text-center" scope="col">{{ __('tour.price') }}</th>
                        <th class="text-center" scope="col">{{ __('tour.status') }}</th>
                        <th class="text-center" scope="col" class="text-center">{{ __('tour.actions') }}</th>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/v/bs5/jq-3.7.0/dt-2.0.8/b-3.0.2/b-html5-3.0.2/b-print-3.0.2/r-3.0.2/datatables.min.js"></script>
    <script type="text/javascript">
      $(document).ready(function(){
        var table = $('#datatables').DataTable({
          ajax: "{{ route('admin.tours.index') }}",
          processing: false,
          serverSide: false,
          responsive: true,
          columns: [
              { data: 'images', className: 'text-center'},
              { data: 'title', className: 'text-center'},
              { data: 'description', className: 'text-center'},
              { data: 'price', className: 'text-center'},
              { data: 'status', className: 'text-center', render: function(data, type, row) {
                return data === 'active'
                    ? '<span class="badge bg-success">{{ __("tour.published") }}</span>'
                    : '<span class="badge bg-secondary">{{ __("tour.draft") }}</span>';
                }
              },
              { data: 'action', name: 'action', orderable: false, searchable: false }
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
            url: "{{ asset('lang/datatables/' . app()->getLocale() . '.json') }}"
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

        $('#galleryForm').on('submit', function(e) {
            e.preventDefault();

            let formData = new FormData(this);
            $('#galleryForm input, #galleryForm select').removeClass('is-invalid');
            $('#galleryForm .invalid-feedback').text('');

            // ➕ Spinner ON
            let $btn = $('#btn-save-gallery');
            $btn.prop('disabled', true);
            $btn.find('.spinner-border').removeClass('d-none');
            $btn.find('.btn-text').html('{{ __("form.in_progress") }}');

            $.ajax({
                url: "{{ route('admin.gallery.store') }}",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    $('#galleryModal').modal('hide');
                    $('#galleryForm')[0].reset();
                    $('#datatables').DataTable().ajax.reload();
                    toastr.success("{{ __('gallery.image_added') }}");
                },
                error: function(xhr) {
                    let errors = xhr.responseJSON.errors;
                    for (let key in errors) {
                        $('#' + key).addClass('is-invalid');
                        $('#error-' + key).text(errors[key][0]);
                    }
                },
                complete: function() {
                    // ➖ Spinner OFF
                    $btn.prop('disabled', false);
                    $btn.find('.spinner-border').addClass('d-none');
                    $btn.find('.btn-text').html('<i class="fas fa-save"></i>&nbsp;{{ __("form.save") }}');
                }
            });
        });

        // Suppression avec confirmation SweetAlert
    });

    $(document).on('click', '.btn-delete-tour', function () {
        let encryptedId = $(this).data('id');
        let url = "{{ route('admin.tours.destroy', ':id') }}".replace(':id', encryptedId);

        Swal.fire({
            title: "{{ __('tour.delete_confirm') }}",
            text: "{{ __('tour.delete_tour_confirm') }}",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#6c757d",
            confirmButtonText: "{{ __('form.yes') }}",
            cancelButtonText: "{{ __('form.no') }}",
            buttonsStyling: false,
            customClass: {
                confirmButton: 'btn btn-sm btn-primary',
                cancelButton: 'btn btn-sm btn-danger ms-1'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        _method: 'DELETE',
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        Swal.fire({
                            title: "{{ __('form.delete') }}",
                            text: response.message,
                            icon: "success",
                            confirmButtonColor: "#3085d6"
                        }).then(() => {
                            $('#datatables').DataTable().ajax.reload(null, false);
                        });
                    },
                    error: function (xhr) {
                        let message = "{{ __('form.delete_error') }}";
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            message = xhr.responseJSON.message;
                        }

                        Swal.fire({
                            title: "{{ __('form.error') }}",
                            text: message,
                            icon: "error"
                        });
                    }
                });
            }
        });
    });
    </script>
@endpush
