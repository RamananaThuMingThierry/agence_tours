<header class="bg-white shadow-sm fixed-top z-50">
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center py-2">
            <!-- Logo -->
            <a href="{{ route('frontoffice') }}" class="navbar-brand fw-bold text-primary">
                <img src="{{ asset(config('public_path.public_path').'utiles/logo.jpg') }}" alt="Logo" height="40">
            </a>

            <!-- Menu -->
            <nav class="d-none d-lg-flex gap-4">
                <a href="{{ route('frontoffice') }}" class="nav-link">{{ __('nav.home') }}</a>
                <a href="" class="nav-link">{{ __('nav.about') }}</a>
                <a href="" class="nav-link">{{ __('nav.testimonials') }}</a>
                <a href="" class="nav-link">{{ __('nav.tours') }}</a>
                <a href="" class="nav-link">{{ __('nav.contact') }}</a>
            </nav>

            <!-- Langue -->
            <div class="dropdown">
                <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" id="langMenu" data-bs-toggle="dropdown" aria-expanded="false">
                    🌐 {{ strtoupper(app()->getLocale()) }}
                </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="langMenu">
                    <li>
                        <a class="dropdown-item {{ app()->getLocale() === 'fr' ? 'active' : '' }}" href="{{ route('lang', 'fr') }}">
                            <img src="{{ asset(config('public_path.public_path') . 'img/icon_fr.png') }}" width="22px" alt="Français" />
                            &nbsp;Français
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item {{ app()->getLocale() === 'en' ? 'active' : '' }}" href="{{ route('lang', 'en') }}">
                            <i class="fas fa-flag-usa"></i>&nbsp;English
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item {{ app()->getLocale() === 'de' ? 'active' : '' }}" href="{{ route('lang', 'de') }}">
                            <i class="fas fa-flag"></i>&nbsp;Deutsch
                        </a>
                    </li>
                </ul>


            </div>
        </div>
    </div>
</header>
