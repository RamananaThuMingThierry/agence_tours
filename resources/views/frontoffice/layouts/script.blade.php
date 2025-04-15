<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset(config('public_path.public_path').'admin/js/scripts.js') }}"></script>
<script>
    $(document).ready(function() {
        document.addEventListener("DOMContentLoaded", function () {
            var toastEl = document.querySelector('.toast');
            if (toastEl) {
                var toast = new bootstrap.Toast(toastEl, { autohide: true, delay: 4000 });
                toast.show();
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
                    alert("Erreur lors du changement de langue : " + xhr.status + " " + error);
                }
            });
        });

        const scrollToTopBtn = document.getElementById("scrollToTopBtn");

        // Afficher le bouton après avoir scrollé de 200px
        window.addEventListener("scroll", () => {
            if (window.scrollY > 200) {
                scrollToTopBtn.style.display = "flex";
            } else {
                scrollToTopBtn.style.display = "none";
            }
        });

        // Scroll vers le haut en douceur
        scrollToTopBtn.addEventListener("click", () => {
            window.scrollTo({
                top: 0,
                behavior: "smooth"
            });
        });

        function updateFooterPosition() {
            const footer = document.getElementById('mainFooter');
            const body = document.body;
            const html = document.documentElement;
            const windowHeight = window.innerHeight;
            const bodyHeight = Math.max(body.scrollHeight, body.offsetHeight,
                                        html.clientHeight, html.scrollHeight, html.offsetHeight);

            if (bodyHeight <= windowHeight) {
                footer.classList.add('fixed-footer');
            } else {
                footer.classList.remove('fixed-footer');
            }
        }

        window.addEventListener('load', updateFooterPosition);
        window.addEventListener('resize', updateFooterPosition);
        window.addEventListener('scroll', updateFooterPosition);

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
                url: "{{ route('reservation') }}",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    $('#reservationModal').modal('hide');
                    $('#reservationForm')[0].reset();
                    toastr.options.positionClass = 'toast-middle-center';
                    toastr.success("{{ __('reservation.created') }}");
                    window.location.href = response.redirect_url;
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

    document.addEventListener("DOMContentLoaded", function () {
        const langDropdown = document.querySelector('.lang-dropdown-mobile');
        const navbarCollapse = document.getElementById('navbarContent');

        function updateLangDropdownVisibility(isVisible) {
            const isMobile = window.innerWidth < 992;
            if (isMobile) {
                langDropdown.style.display = isVisible ? 'block' : 'none';
            } else {
                langDropdown.style.display = 'block'; // Toujours visible en desktop
            }
        }

        // ▶ Afficher quand le menu est complètement ouvert
        navbarCollapse.addEventListener('shown.bs.collapse', () => {
            updateLangDropdownVisibility(true);
        });

        // ▶ Cacher quand le menu est complètement fermé
        navbarCollapse.addEventListener('hidden.bs.collapse', () => {
            updateLangDropdownVisibility(false);
        });

        // ▶ Initialisation au chargement
        updateLangDropdownVisibility(navbarCollapse.classList.contains('show'));

        // ▶ Adapter si on resize
        window.addEventListener('resize', () => {
            const isMobile = window.innerWidth < 992;
            const isShown = navbarCollapse.classList.contains('show');
            updateLangDropdownVisibility(isMobile ? isShown : true);
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        // Quand un bouton "reserved" est cliqué
        document.querySelectorAll('[data-bs-toggle="modal"][data-bs-target="#reservationModal"]').forEach(button => {
            button.addEventListener('click', function () {
                const tourId = this.getAttribute('data-tour-id');
                document.getElementById('tour_id').value = tourId;
            });
        });
    });
</script>
