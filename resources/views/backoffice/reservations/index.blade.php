@extends('backoffice.admin')

@section('titre', __('title.reservations'))

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/v/bs5/jq-3.7.0/dt-2.0.8/b-3.0.2/b-html5-3.0.2/b-print-3.0.2/r-3.0.2/datatables.min.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"/>
@endpush

@section('content')
    @include('backoffice.reservations.show')
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
                        <th class="text-center" scope="col">{{ __('form.date') }}</th>
                        <th class="text-center" scope="col">{{ __('form.name') }}</th>
                        <th class="text-center" scope="col">{{ __('form.email') }}</th>
                        <th class="text-center" scope="col">{{ __('form.phone') }}</th>
                        <th class="text-center" scope="col">{{ __('form.message') }}</th>
                        <th class="text-center" scope="col">{{ __('sidebar.tour') }}</th>
                        <th class="text-center" scope="col">{{ __('form.status') }}</th>
                        <th class="text-center" scope="col" class="text-center">{{ __('form.actions') }}</th>
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
                ajax: "{{ route('admin.reservations.index') }}",
                processing: false,
                serverSide: false,
                responsive: true,
                order: [[0, 'desc']],
                columns: [
                    {
                        data: 'created_at',
                        className: 'text-center',
                        render: function(data) {
                            const date = new Date(data);
                            return date.toLocaleDateString() + ' ' + date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                        }
                    },
                    { data: 'name', className: 'text-center' },
                    { data: 'email', className: 'text-center' },
                    { data: 'phone', className: 'text-center' },
                    { data: 'message', className: 'text-center' },
                    {
                        data: 'tour.title',
                        className: 'text-center',
                        render: function(data) {
                            return data ?? '-';
                        }
                    },
                    {
                        data: 'status',
                        className: 'text-center',
                        render: function(data) {
                            let badgeClass = data === 'pending' ? 'bg-warning' : 'bg-success';
                            let label = data === 'pending' ? '{{ __("form.pending") }}' : '{{ __("form.seen") }}';
                            return `<span class="badge ${badgeClass}">${label}</span>`;
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
                        customize: function (doc) {
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
                        action: function () {
                            location.reload();
                        }
                    }
                ],
                columnDefs: [
                    { targets: -1, orderable: false }
                ],
                language: {
                    url: "{{ asset(config('public_path.public_path').'lang/datatables/' . app()->getLocale() . '.json') }}"
                },
                initComplete: function () {
                    function getRandomColor() {
                        var letters = '0123456789ABCDEF';
                        var color = '#';
                        for (var i = 0; i < 6; i++) {
                            color += letters[Math.floor(Math.random() * 16)];
                        }
                        return color;
                    }

                    $('.dt-buttons button').each(function () {
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

            $('#reservationForm').on('submit', function(e) {
                e.preventDefault();

                let form = $(this);
                let formData = new FormData(this);

                form.find('input, select, textarea').removeClass('is-invalid');
                form.find('.invalid-feedback').text('');

                let $btn = $('#btn-save-reservation');
                $btn.prop('disabled', true);
                $btn.find('.spinner-border').removeClass('d-none');
                $btn.find('.btn-text').html('{{ __("form.in_progress") }}');

                $.ajax({
                    url: "{{ route('admin.reservations.store') }}",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $('#reservationModal').modal('hide');
                        $('#reservationForm')[0].reset();
                        $('#datatables').DataTable().ajax.reload(null, false);
                        toastr.options.positionClass = 'toast-middle-center';
                        toastr.success("{{ __('reservation.created') }}");
                    },
                    error: function(xhr) {
                        let errors = xhr.responseJSON.errors;
                        for (let key in errors) {
                            $('#' + key).addClass('is-invalid');
                            $('#error-' + key).text(errors[key][0]);
                        }
                    },
                    complete: function() {
                        $btn.prop('disabled', false);
                        $btn.find('.spinner-border').addClass('d-none');
                        $btn.find('.btn-text').html('<i class="fas fa-save"></i> {{ __("form.save") }}');
                    }
                });
            });
        });

        $(document).on('click', '#btn-show-reservation', function () {
            const encryptedId = $(this).data('id');

            $.ajax({
                url: '/backoffice/reservations/' + encryptedId,
                type: 'GET',
                success: function (response) {
                    if (response.status) {
                        const res = response.data;

                        $('#res-name').text(res.name);
                        $('#res-email').text(res.email);
                        $('#res-phone').text(res.phone);
                        $('#res-message').text(res.message ?? '-');
                        $('#res-tour').text(res.tour?.title ?? '-');

                        const badge = res.status === 'pending'
                            ? '<span class="badge bg-warning">{{ __("form.pending") }}</span>'
                            : '<span class="badge bg-success">{{ __("form.seen") }}</span>';
                        $('#res-status').html(badge);

                        $('#reservationDetailModal').modal('show');

                        // Rafraîchir la table pour mettre à jour le badge
                        $('#datatables').DataTable().ajax.reload(null, false);
                    }
                },
                error: function (xhr) {
                    toastr.options.positionClass = 'toast-middle-center';
                    toastr.error("Erreur lors du chargement de la réservation.");
                }
            });
        });

        $(document).on('click', '#btn-delete-reservation-confirm', function () {
            let encryptedId = $(this).data('id');

            Swal.fire({
                title: "{{ __('form.delete_confirm') }}",
                text: "{{ __('reservation.confirm_delete_text') }}",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "{{ __('form.yes') }}",
                cancelButtonText: "{{ __('form.no') }}",
                customClass: {
                    confirmButton: 'btn btn-sm btn-dark',
                    cancelButton: 'btn btn-sm btn-danger ms-1'
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/backoffice/reservations/' + encryptedId,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (response) {
                            Swal.fire({
                                icon: 'success',
                                title: "{{ __('form.delete') }}",
                                text: response.message,
                                timer: 2000,
                                showConfirmButton: false
                            });
                            $('#datatables').DataTable().ajax.reload(null, false);
                        },
                        error: function (xhr) {
                            let message = xhr.responseJSON?.message ?? "{{ __('form.delete_error') }}";
                            Swal.fire({
                                icon: 'error',
                                title: "{{ __('form.error') }}",
                                text: message
                            });
                        }
                    });
                }
            });
        });
    </script>
@endpush
