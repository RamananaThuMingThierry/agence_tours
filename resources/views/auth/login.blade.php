@extends('auth.app')

@section('titre', "Connexion")

@section('content')
    <section id="login-register" class="vh-100" style="background: url('{{ asset(config('public_path.public_path').'utiles/login.jpg') }}') no-repeat center center/cover;">
        <div class="container h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col col-md-10">
                    <div class="card" style="border-radius: 1rem;">
                        <div class="row g-0">
                            <div class="col-md-6 col-lg-5 d-none d-md-block">
                                <div class="d-flex justify-content-center align-items-center h-100">
                                    <img src="{{ asset(config('public_path.public_path').'utiles/logo.jpg') }}" alt="login form" class="img-fluid" />
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-7 d-flex align-items-center">
                                <div class="card-body p-4 p-lg-5 text-black">

                                    <form id="login-form" method="POST" action="{{ route('login.post') }}" class="needs-validation" novalidate>
                                        @csrf

                                        <div class="d-flex align-items-center mb-3 pb-1">
                                            <i class="fas fa-sign-in-alt fa-2x me-3 d-none d-md-block" style="color: #af8511;"></i>
                                            <img src="{{ asset(config('public_path.public_path').'utiles/logo.jpg') }}"
                                                 alt="login form"
                                                 class="img-fluid d-block d-md-none"
                                                 style="width:50px;"
                                            />
                                            <span class="h1 fw-bold mb-0">{{ __('login.login') }}</span>
                                        </div>

                                        <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">{{ __('login.login_subtitle') }}</h5>

                                        <div class="form-outline mb-3">
                                            <label class="form-label" for="email">{{ __('login.email') }}</label>
                                            <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" required autocomplete="off"/>
                                            <div class="invalid-feedback">@error('email') {{ $message }} @else {{ __('login.email_required') }} @enderror</div>
                                        </div>

                                        <div class="form-outline mb-3">
                                            <label class="form-label" for="password">{{ __('login.password') }}</label>
                                            <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" required autocomplete="off"/>
                                            <div class="invalid-feedback">@error('password') {{ $message }} @else {{ __('login.password_required') }} @enderror</div>
                                        </div>

                                        <!-- Champ caché pour stocker le token reCAPTCHA v3 -->
                                        <input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response">

                                        @if ($errors->has('g-recaptcha-response'))
                                            <div class="alert alert-danger">
                                                {{ $errors->first('g-recaptcha-response') }}
                                            </div>
                                        @endif

                                        <div class="pt-1 mb-4">
                                            <button id="login-btn" class="btn text-uppercase btn-sm btn-danger w-100" type="submit">
                                                {{ __('login.log_in') }}
                                            </button>
                                        </div>

                                        <p class="mb-5 pb-lg-2">{{ __('login.do_not_have_an_account') }} <a href="{{ route('register') }}"
                                            style="color: #8b7f0e;">{{ __('login.sign_up') }}</a></p>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('script')
    <script>
        $(document).ready(function () {
            $('#login-form').on('submit', function (e) {
                e.preventDefault(); // Empêcher la soumission classique

                var form = $(this);
                var button = $('#login-btn');
                var originalContent = button.html();
                var loadingContent = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Chargement...';

                // Désactiver le bouton et afficher un spinner
                button.html(loadingContent).prop('disabled', true);

                // Envoyer le formulaire avec AJAX
                $.ajax({
                    url: form.attr('action'),
                    method: "POST",
                    data: form.serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val()
                    },
                    success: function (response) {
                        if (response.success) {
                            Swal.fire({
                                title: '{{ __("login.success_connection") }}',
                                text: '{{ __("login.redirected_dashboard") }}',
                                icon: 'success',
                            });
                            button.html(originalContent).prop('disabled', false);
                            window.location.href = "{{ route('admin.dashboard') }}";
                        }
                    },
                    error: function (xhr) {
                        button.html(originalContent).prop('disabled', false);

                        if (xhr.status === 422) {
                            var response = xhr.responseJSON;

                            // Afficher les erreurs
                            if (response.errors && response.errors["g-recaptcha-response"]) {
                                $('#recaptcha-error').text(response.errors["g-recaptcha-response"][0]).show();
                            }
                        } else {
                            Swal.fire({
                                title: '{{ __("login.error") }}',
                                text: '{{ __("login.error_text") }}',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    }
                });
            });
        });
    </script>
@endpush
