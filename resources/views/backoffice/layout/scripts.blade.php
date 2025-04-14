<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset(config('public_path.public_path').'admin/js/scripts.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {
        document.addEventListener("DOMContentLoaded", function () {
            var toastEl = document.querySelector('.toast');
            if (toastEl) {
                var toast = new bootstrap.Toast(toastEl, { autohide: true, delay: 4000 });
                toast.show();
            }
        });

        $.ajax({
            url: '/admin/badge',
            method: 'GET',
            success: function(response) {
                console.log(response);
                $('#groupes-count').text(response.groupes ?? '0');
                $('#fonctions-count').text(response.fonctions ?? '0');
                $('#membres-count').text(response.membres ?? '0');
                $('#users-count').text(response.users ?? '0');
                $('#actualites-count').text(response.actualites ?? '0');
                $('#pending_membres').text(response.pending_membres ?? '0');
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
        });

        $('.lang-change').on('click', function (event) {
            event.preventDefault(); // Empêche l'action par défaut du lien

            var lang = $(this).data('lang'); // Récupère la langue sélectionnée

            // Envoie la requête AJAX pour changer la langue
            $.ajax({
                url: "{{ route('lang', ['lang' => ':lang']) }}".replace(':lang', lang),
                method: 'GET',
                dataType: 'json',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest', // Indique que la requête est faite via AJAX
                },
                success: function (data) {
                    // Si la langue a été changée avec succès, mettre à jour l'interface
                    if (data.locale) {
                        $('#current-lang').text(data.locale === 'fr' ? 'Français' : (data.locale === 'de' ? 'Deutsch' : 'English'));
                        location.reload();
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Erreur lors du changement de langue:', xhr.responseText);
                    // Affiche un message d'erreur détaillé
                    alert("Erreur lors du changement de langue : " + xhr.status + " " + error);
                }
            });
        });
    });

    document.getElementById('logout-link').addEventListener('click', function(event) {
        event.preventDefault();
        Swal.fire({
            title: 'Êtes-vous sûr ?',
            text: "Vous allez être déconnecté.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Oui, déconnectez-moi!',
            cancelButtonText: 'Annuler'
        }).then((result) => {
            if (result.isConfirmed) {
                var logoutForm = document.createElement('form');
                logoutForm.action = "{{ route('logout') }}";
                logoutForm.method = 'POST';
                logoutForm.style.display = 'none';
                logoutForm.innerHTML = '@csrf';
                document.body.appendChild(logoutForm);
                logoutForm.submit();
            }
        });
    });
</script>
