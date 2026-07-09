<!DOCTYPE html>
<html lang="fr">

<!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta content="Codescandy" name="author">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('dasher/dash/assets/libs/swiper/swiper-bundle.min.css') }}" />
    <!-- Favicon icon-->
    <link class="apple-touch-icon" sizes="57x57"
        href="{{ asset('dasher/dash/assets/images/favicon/apple-icon-57x57.png') }}" />
    <link class="apple-touch-icon" sizes="60x60"
        href="{{ asset('dasher/dash/assets/images/favicon/apple-icon-60x60.png') }}" />
    <link class="apple-touch-icon" sizes="72x72"
        href="{{ asset('dasher/dash/assets/images/favicon/apple-icon-72x72.png') }}" />
    <link class="apple-touch-icon" sizes="76x76"
        href="{{ asset('dasher/dash/assets/images/favicon/apple-icon-76x76.png') }}" />
    <link class="apple-touch-icon" sizes="114x114"
        href="{{ asset('dasher/dash/assets/images/favicon/apple-icon-114x114.png') }}" />
    <link class="apple-touch-icon" sizes="120x120"
        href="{{ asset('dasher/dash/assets/images/favicon/apple-icon-120x120.png') }}" />
    <link class="apple-touch-icon" sizes="144x144"
        href="{{ asset('dasher/dash/assets/images/favicon/apple-icon-144x144.png') }}" />
    <link class="apple-touch-icon" sizes="152x152"
        href="{{ asset('dasher/dash/assets/images/favicon/apple-icon-152x152.png') }}" />
    <link class="apple-touch-icon" sizes="180x180"
        href="{{ asset('dasher/dash/assets/images/favicon/apple-icon-180x180.png') }}" />
    <link rel="icon" type="image/png" sizes="192x192"
        href="{{ asset('dasher/dash/assets/images/favicon/android-icon-192x192.png') }}" />
    <link rel="icon" type="image/png" sizes="32x32"
        href="{{ asset('dasher/dash/assets/images/favicon/favicon-32x32.png') }}" />
    <link rel="icon" type="image/png" sizes="96x96"
        href="{{ asset('dasher/dash/assets/images/favicon/favicon-96x96.png') }}" />
    <link rel="icon" type="image/png" sizes="16x16"
        href="{{ asset('dasher/dash/assets/images/favicon/favicon-16x16.png') }}" />

    <meta name="msapplication-TileColor" content="#ffffff" />
    <meta name="msapplication-TileImage"
        content="{{ asset('dasher/dash/assets/images/favicon/ms-icon-144x144.png') }}" />
    <meta name="theme-color" content="#ffffff" />
    <!-- Color modes -->
    <script src="{{ asset('dasher/dash/assets/js/vendors/color-modes.js') }}"></script>
    <script>
        if (localStorage.getItem('sidebarExpanded') === 'false') {
            document.documentElement.classList.add('collapsed');
            document.documentElement.classList.remove('expanded');
        } else {
            document.documentElement.classList.remove('collapsed');
            document.documentElement.classList.add('expanded');
        }
    </script>
    <!-- Libs CSS -->
    <link rel="preconnect" href="https://fonts.googleapis.com/" />
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin />
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700;800&amp;display=swap" />
    <link rel="stylesheet" href="{{ asset('dasher/dash/assets/libs/simplebar/dist/simplebar.min.css') }}" />
    <link rel="stylesheet"
        href="{{ asset('dasher/dash/assets/libs/%40tabler/icons-webfont/tabler-icons.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('dasher/dash/assets/css/theme.min.css') }}">

</head>

<body>
    <div>
        <div id="miniSidebar" style="top: 60px">
            <div class="brand-logo">
                <a class='d-none d-md-flex align-items-center gap-2 text-decoration-none py-4 px-3' href='#'>
                    <img src="" />
                    <span class="fw-bold fs-4 text-dark site-logo-text" style="left: 10px; top: 100px">Suivi Pénitencier
                    </span>
                </a>
            </div>

            <ul class="navbar-nav flex-column">
                <li class="nav-item">
                    <a class='nav-link active bg-light text-primary' href='{{ route('admin.dashboard') }}'>
                        <span class="nav-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                stroke-linejoin="round" class="icon icon-tabler icon-tabler-layout-dashboard">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M4 4h6v8h-6z" />
                                <path d="M4 16h6v4h-6z" />
                                <path d="M14 12h6v8h-6z" />
                                <path d="M14 4h6v4h-6z" />
                            </svg>
                        </span>
                        <span class="text fw-semibold">Tableau de Bord</span>
                    </a>
                </li>

                <li class="nav-item mt-3">
                    <div class="nav-heading px-3 text-uppercase fs-7 text-muted fw-bold">Recensement</div>
                    <hr class="mx-3 nav-line mb-2 mt-1" />
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <span class="nav-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="icon icon-tabler icon-tabler-users">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                                <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                <path d="M21 21v-2a4 4 0 0 0 -3 -3.85" />
                            </svg>
                        </span>
                        <span class="text">Registre des Détenus</span>
                    </a>
                    <ul class="dropdown-menu flex-column">
                        <li class="nav-item">
                            <a class='nav-link' href='{{ route('admin.search') }}'>Consultation Recherche </a>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item mt-3">
                    <div class="nav-heading px-3 text-uppercase fs-7 text-muted fw-bold">Modules</div>
                    <hr class="mx-3 nav-line mb-2 mt-1" />
                </li>


                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.archive') }}">
                        <span class="nav-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="icon icon-tabler icon-tabler-archive">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path
                                    d="M3 4m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z" />
                                <path d="M5 8v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-10" />
                                <path d="M10 12l4 0" />
                            </svg>
                        </span>
                        <span class="text">Archives</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.medicale') }}">
                        <span class="nav-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="icon icon-tabler icon-tabler-truck-medical">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M6 17m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                <path d="M17 17m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                <path d="M5 17h-2v-11a1 1 0 0 1 1 -1h9v12m-4 0h6m4 0h2v-6h-8m0 -5h5l3 5" />
                                <path d="M6 10h4" />
                                <path d="M8 8v4" />
                            </svg>
                        </span>
                        <span class="text">Extractions Médicales</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.audit') }}">
                        <span class="nav-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="icon icon-tabler icon-tabler-history">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 8l0 4l2 2" />
                                <path d="M3.05 11a9 9 0 1 1 .5 4m-.5 5v-5h5" />
                            </svg>
                        </span>
                        <span class="text">Journal d'Audit</span>
                    </a>
                </li>


                <li class="nav-item">
                    <a class='nav-link' href='{{ route('admin.sortie.listes') }}'>
                        <span class="nav-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="icon icon-tabler icon-tabler-calendar-due">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path
                                    d="M4 5m0 2a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2z" />
                                <path d="M16 3v4" />
                                <path d="M8 3v4" />
                                <path d="M4 11h16" />
                                <path d="M12 16l1 1l3 -3" />
                            </svg>
                        </span>
                        <span class="text">Sorties du mois en cours</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class='nav-link' href='{{ route('admin.deces.listes') }}'>
                        <span class="nav-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="icon icon-tabler icon-tabler-file-alert">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                                <path d="M12 17l.01 0" />
                                <path d="M12 11l0 3" />
                            </svg>
                        </span>
                        <span class="text">Registre des Décès</span>
                    </a>
                </li>

                {{-- Infraction --}}
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.infraction.index') }}">
                        <span class="nav-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="icon icon-tabler icon-tabler-file-alert">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                                <path d="M12 17l.01 0" />
                                <path d="M12 11l0 3" />
                            </svg>
                        </span>
                        <span class="text">liste des infractions</span>
                    </a>
                </li>

                {{-- Juridictions --}}
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.juridiction.index') }}">
                        <span class="nav-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="icon icon-tabler icon-tabler-file-alert">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                                <path d="M12 17l.01 0" />
                                <path d="M12 11l0 3" />
                            </svg>
                        </span>
                        <span class="text">liste des juridictions</span>
                    </a>
                </li>
                {{-- Types d'infractions --}}
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.infraction.types') }}">
                        <span class="nav-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="icon icon-tabler icon-tabler-file-alert">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                                <path d="M12 17l.01 0" />
                                <path d="M12 11l0 3" />
                            </svg>
                        </span>
                        <span class="text">Types d'infractions</span>
                    </a>
                </li>

            </ul>
        </div>
    </div>



    {{-- Barre supérieure : établissement connecté, utilisateur et déconnexion --}}
    <div class="position-fixed top-0 end-0 p-3 z-3" style="left: 0px; top:0px">
        <div class="d-flex align-items-center justify-content-between bg-white shadow-sm rounded-3 px-4 py-2 mt-2">
            <div class="d-flex align-items-center gap-2">
                @php
                    $typePrison = session('type_prison', 'homme');
                    $libellePrison = $typePrison === 'femme' ? 'Prison pour femmes' : 'Prison pour hommes';
                    $badgeClass =
                        $typePrison === 'femme' ? 'bg-danger-subtle text-danger' : 'bg-primary-subtle text-primary';
                @endphp
                <span class="badge {{ $badgeClass }} fs-6 px-3 py-2">
                    <i class="ti ti-building me-1"></i>{{ $libellePrison }}
                </span>
            </div>
            <div class="d-flex align-items-center gap-3">
                <span class="text-muted small d-none d-md-inline">
                    <i class="ti ti-user me-1"></i>{{ Auth::user()->name ?? 'Utilisateur' }}
                </span>
                <form method="POST" action="{{ route('logout') }}" class="mb-0">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm">
                        <i class="ti ti-logout me-1"></i> Déconnexion
                    </button>
                </form>
            </div>
        </div>
    </div>

    @yield('suite')
    <!-- Libs JS -->
    <script src="{{ asset('dasher/dash/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('dasher/dash/assets/libs/simplebar/dist/simplebar.min.js') }}"></script>

    <!-- Theme JS -->
    <script src="{{ asset('dasher/dash/assets/js/theme.min.js') }}"></script>

    <script src="{{ asset('dasher/dash/assets/js/vendors/sidebarnav.js') }}"></script>
    <script src="{{ asset('dasher/dash/assets/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
    <script src="{{ asset('dasher/dash/assets/js/vendors/chart.js') }}"></script>
    <script src="{{ asset('dasher/dash/assets/libs/swiper/swiper-bundle.min.css') }}"></script>
    <script src="{{ asset('dasher/dash/assets/js/vendors/swiper.js') }}"></script>
</body>

<!-- Mirrored from dasher-ui.netlify.app/ by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 23 Dec 2025 14:38:10 GMT -->

</html>
