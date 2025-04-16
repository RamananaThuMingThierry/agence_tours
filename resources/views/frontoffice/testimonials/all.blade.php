@extends('frontoffice.app')

@push('style')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"/>
    <style>
        .bg-header{
            background-color: #ffc107;
        }

        .nav-link:hover {
            color: #ffc107 !important;
        }
        .divider {
            width: 60px;
            height: 4px;
            background-color: #ffc107;
            border-radius: 2px;
        }

        #scrollToTopBtn {
            position: fixed;
            bottom: 30px;
            right: 20px;
            display: none;
            z-index: 9999;
            width: 45px;
            height: 45px;
            font-size: 18px;
            justify-content: center;
            align-items: center;
        }

        #scrollToTopBtn:hover {
            background-color: #c82333;
        }

        #testimonials{
            margin-top: 30px;
        }

        .fixed-footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            z-index: 1000;
        }

        @media (max-width: 991.98px) {
            .nav-link:hover {
                color: #ffffff !important;
            }
        }
    </style>
@endpush

@section('content')
    @include('frontoffice.testimonials.index')
    <div id="testimonial_formulaire" style="background-color: #c0c0c0;" class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold text-danger">FORMULAIRE</h2>
                <div class="mx-auto mt-2" style="width: 60px; height: 4px; background-color: #ffc107;"></div>
            </div>
            <form id="testimonialForm" enctype="multipart/form-data">
                @csrf
                        <div class="row mb-3">
                            <div class="col-12">
                                <label for="name" class="form-label fw-bold">{{ __('testimonial.name') }}</label>
                                <input type="text" class="form-control" id="name" name="name">
                                <div class="invalid-feedback" id="error-name"></div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-12">
                                <label for="rating" class="form-label fw-bold">{{ __('testimonial.rating') }}</label>
                                <select class="form-select" id="rating" name="rating">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <option value="{{ $i }}">{{ $i }} ★</option>
                                    @endfor
                                </select>
                                <div class="invalid-feedback" id="error-rating"></div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-12">
                                <label for="message" class="form-label fw-bold">{{ __('testimonial.message') }}</label>
                                <textarea class="form-control" id="message" name="message" rows="4"></textarea>
                                <div class="invalid-feedback" id="error-message"></div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label fw-bold">{{ __('testimonial.image') }}</label>
                            <input type="file" class="form-control" id="image" name="image">
                            <div class="invalid-feedback" id="error-image"></div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-sm btn-dark" id="btn-save-testimonial">
                                <span class="spinner-border spinner-border-sm d-none me-1" role="status" aria-hidden="true"></span>
                                <span class="btn-text"><i class="fas fa-save"></i>&nbsp;{{ __('form.save') }}</span>
                            </button>
                        </div>
            </form>
        </div>
    </div>
    @include('frontoffice.layouts.footer')
@endsection

@push('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function () {
            $('#testimonialForm').on('submit', function (e) {
                e.preventDefault();

                let formData = new FormData(this);
                $('#testimonialForm input, #testimonialForm textarea, #testimonialForm select').removeClass('is-invalid');
                $('#testimonialForm .invalid-feedback').text('');

                // Spinner ON
                const $btn = $('#btn-save-testimonial');
                $btn.prop('disabled', true);
                $btn.find('.spinner-border').removeClass('d-none');
                $btn.find('.btn-text').html("{{ __('form.in_progress') }}");

                $.ajax({
                    url: "{{ route('admin.testimonials.store') }}",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        console.log(response);
                        $('#testimonialForm')[0].reset();
                        toastr.options.positionClass = 'toast-middle-center';
                        toastr.success("{{ __('testimonial.added') }}");
                    },
                    error: function (xhr) {
                        const errors = xhr.responseJSON.errors;
                        for (let key in errors) {
                            $(`#${key}`).addClass('is-invalid');
                            $(`#error-${key}`).text(errors[key][0]);
                        }
                    },
                    complete: function () {
                        $btn.prop('disabled', false);
                        $btn.find('.spinner-border').addClass('d-none');
                        $btn.find('.btn-text').html('<i class="fas fa-save"></i>&nbsp;{{ __("form.save") }}');
                    }
                });
            });
        });
    </script>
@endpush

