<nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
    <div class="sb-sidenav-menu">
        <div class="nav">
            <div class="sb-sidenav-menu-heading">Core</div>
                @include('admin.widget.nav_link', ['url' => route('admin.dashboard'), 'icon' => 'fa-tachometer-alt', 'name' => 'Tableau de bord'])
            <div class="sb-sidenav-menu-heading">Interface</div>
                @include('admin.widget.nav_link', ['url' => route('admin.fonctions.index'), 'icon' => 'fa-calendar', 'name' => 'Fonctions', 'ids' => 'fonctions-count'])
                @include('admin.widget.nav_link', ['url' => route('admin.groupes.index'), 'icon' => 'fa-network-wired', 'name' => 'Groupes', 'ids' => 'groupes-count'])
                @include('admin.widget.nav_link', ['url' => route('admin.membres.index'),'icon' => 'fa-book-open', 'name' => 'Membres', 'ids' => 'membres-count'])
            <div class="sb-sidenav-menu-heading">ADMIN</div>
                @include('admin.widget.nav_link', ['url' => route('admin.actualites.index'), 'icon' => 'bi-newspaper', 'name' => 'Actualités', 'ids' => 'actualites-count', 'faIcons' => false])
                @include('admin.widget.nav_link', ['url' => route('admin.activites.index'), 'icon' => 'bi-newspaper', 'name' => 'Activites', 'ids' => 'activites-count', 'faIcons' => false])
                @include('admin.widget.nav_link', ['url' => route('admin.contacts.index'),'icon' => 'fa-phone', 'name' => 'Contacts', 'ids' => 'contacts-count'])
                @include('admin.widget.nav_link', ['url' => route('admin.documents.index'),'icon' => 'fa-books', 'name' => 'Documents', 'ids' => 'documents-count'])
                @include('admin.widget.nav_link', ['url' => route('admin.evenements.index'),'icon' => 'fa-calendar-alt', 'name' => 'Événements', 'ids' => 'evenements-count'])
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseMessages" aria-expanded="false" aria-controls="collapseMessages">
                    <div class="sb-nav-link-icon"><i class="bi bi-chat-square-text-fill"></i></div>
                    Messages
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseMessages" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="{{ route('admin.sms') }}"><i class="bi bi-chat-text-fill"></i>&nbsp;SMS</a>
                        <a class="nav-link" href="{{ route('admin.email') }}"><i class="bi bi-envelope-at"></i>&nbsp;Email</a>
                        <a class="nav-link" href="{{ route('admin.historique') }}"><i class="bi bi-clock-history"></i>&nbsp;Historiques</a>
                    </nav>
                </div>
                @include('admin.widget.nav_link', ['url' => route('admin.pendingmembres'), 'icon' => 'fa-spinner fa-spin', 'name' => 'Membres en Attente', 'ids' => 'pending_membres'])
                @include('admin.widget.nav_link', ['url' => route('admin.cotisations.index'), 'icon' => 'fa-money-bill-wave', 'name' => 'Cotisations'])
                @include('admin.widget.nav_link', ['url' => route('admin.users.index'), 'icon' => 'fa-users', 'name' => 'Utilisateurs', 'ids' => 'users-count'])
        </div>
    </div>
</nav>