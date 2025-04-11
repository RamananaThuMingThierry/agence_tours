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
                                            <span class="h1 fw-bold mb-0">Connexion</span>
                                        </div>

                                        <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Connectez-vous à votre compte</h5>

                                        <div class="form-outline mb-3">
                                            <label class="form-label" for="email">Adresse email</label>
                                            <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" required autocomplete="off"/>
                                            <div class="invalid-feedback">@error('email') {{ $message }} @else Veuillez saisir une adresse email valide. @enderror</div>
                                        </div>

                                        <div class="form-outline mb-3">
                                            <label class="form-label" for="password">Mot de passe</label>
                                            <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" required autocomplete="off"/>
                                            <div class="invalid-feedback">@error('password') {{ $message }} @else Veuillez saisir votre mot de passe. @enderror</div>
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
                                                Se connecter
                                            </button>
                                        </div>

                                        <p class="mb-5 pb-lg-2">Vous n'avez pas de compte? <a href="{{ route('register') }}"
                                            style="color: #8b7f0e;">S'inscrire</a></p>
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
    <!-- reCAPTCHA v3 -->
    <script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.sitekey') }}"></script>
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

                grecaptcha.ready(function () {
                    grecaptcha.execute("{{ config('services.recaptcha.sitekey') }}", { action: "login" }).then(function (token) {
                        $('#g-recaptcha-response').val(token);

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
                                        title: 'Connexion réussie!',
                                        text: 'Vous serez redirigé vers votre tableau de bord...',
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
                                    Swal.fire('Erreur!', 'Une erreur inattendue s\'est produite.', 'error');
                                }
                            }
                        });
                    });
                });
            });
        });
    </script>
@endpush
