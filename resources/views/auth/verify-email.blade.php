@extends('auth.app')

@section('titre', 'En atttente')

@push('styles')
  <style>
        body{
          background-color: hsl(162, 79%, 13%) !important; /* Vert Bootstrap */
        }
  </style>
@endpush
   
@section('content')
  @include('admin.modal.logout')
  <div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card p-2 shadow-sm">
                <p>Bonjour <span class="fw-bold text-danger">{{ Auth::user()->pseudo }}</span>,</p>
                <p>Avant de continuer, veuillez vérifier votre boîte de réception pour le lien de vérification. Si vous ne l'avez pas reçu, nous pouvons vous envoyer un autre email.</p>
                <hr>
                <form id="resend-verification-form">
                    @csrf
                    <button type="button" class="btn btn-sm btn-warning" id="resend-verification-btn">Renvoyer l'email de vérification</button>
                </form>  
            </div>
        </div>
    </div>
  </div>
@endsection

@push('script')
    <script>
        $('#resend-verification-btn').on('click', function() {
            var button = $(this);
            var originalContent = button.html();
            var loadingContent = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Chargement...';

            button.html(loadingContent);
            button.prop('disabled', true);

            $.ajax({
                url: "{{ route('verification.resend') }}",
                method: "POST",
                data: {
                    _token: $('input[name="_token"]').val()
                },
                success: function(response) {
                    button.html(originalContent);
                    button.prop('disabled', false);
                    Swal.fire(
                        'Email envoyé!',
                        'Un nouveau lien de vérification a été envoyé à votre adresse email.',
                        'success'
                    );
                },
                error: function(xhr) {
                    button.html(originalContent);
                    button.prop('disabled', false);
                    Swal.fire(
                        'Erreur!',
                        'Une erreur est survenue lors de l\'envoi de l\'email de vérification.',
                        'error'
                    );
                }
            });
        });

    </script>
@endpush