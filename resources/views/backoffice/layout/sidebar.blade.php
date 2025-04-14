<nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
    <div class="sb-sidenav-menu">
        <div class="nav">
            <div class="sb-sidenav-menu-heading">Core</div>
                @include('backoffice.widget.nav_link', ['url' => route('admin.dashboard'), 'icon' => 'fa-tachometer-alt', 'name' => 'sidebar.dashboard'])
            <div class="sb-sidenav-menu-heading">ADMIN</div>
                @include('backoffice.widget.nav_link', ['url' => route('admin.gallery.index'), 'icon' => 'fa-images', 'name' => 'sidebar.gallery', 'ids' => 'gallery-count', 'faIcons' => false])
                @include('backoffice.widget.nav_link', ['url' => route('admin.reservations.index'), 'icon' => 'fa-calendar-check', 'name' => 'sidebar.reservation', 'ids' => 'reservation-count', 'faIcons' => false])
                @include('backoffice.widget.nav_link', ['url' => route('admin.slides.index'),'icon' => 'fa-sliders-h', 'name' => 'sidebar.slide', 'ids' => 'slide-count'])
                @include('backoffice.widget.nav_link', ['url' => '','icon' => 'fa-comment-dots', 'name' => 'sidebar.testimonial', 'ids' => 'testimonial-count'])
                @include('backoffice.widget.nav_link', ['url' => route('admin.tours.index'),'icon' => 'fa-globe-europe', 'name' => 'sidebar.tour', 'ids' => 'tour-count'])
                @include('backoffice.widget.nav_link', ['url' => '','icon' => 'fa-users', 'name' => 'sidebar.user', 'ids' => 'user-count'])
        </div>
    </div>
</nav>
