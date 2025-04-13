@extends('backoffice.admin')

@section('titre', __('title.reservations'))

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/v/bs5/jq-3.7.0/dt-2.0.8/b-3.0.2/b-html5-3.0.2/b-print-3.0.2/r-3.0.2/datatables.min.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"/>
@endpush

@section('content')
    @include('backoffice.reservations.create')

    <div class="row pt-2">
        <div class="col-12 d-flex align-items-center justify-content-between">
            <h2 class="text-primary">@yield('titre')</h2>
            <button class="btn btn-sm btn-success shadow-sm d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#reservationModal">
                <i class="fas fa-plus p-1 text-white-50"></i>
                <span class="d-none d-sm-inline">&nbsp;{{ __('reservation.add') }}</span>
            </button>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-12">
        <div class="card rounded-0 p-3 shadow-sm">
                <div class="table-responsive">
                    <table id="datatables" class="table table-striped table-bordered display w-100">
                        <thead class="table-dark">
                        <th class="text-center" scope="col">{{ __('form.name') }}</th>
                        <th class="text-center" scope="col">{{ __('form.email') }}</th>
                        <th class="text-center" scope="col">{{ __('form.message') }}</th>
                        <th class="text-center" scope="col">Tours</th>
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
                columns: [
                    { data: 'name', className: 'text-center'},
                    { data: 'email', className: 'text-center'},
                    { data: 'phone', className: 'text-center'},
                    { data: 'message', className: 'text-center'},
                    { date: 'tour_id', className: 'text-center'},
                    { data: 'status', className: 'text-center'},
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
    </script>
@endpush
