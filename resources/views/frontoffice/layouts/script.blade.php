<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
    });
</script>
