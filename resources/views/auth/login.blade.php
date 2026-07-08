<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Connexion | Gestion Pénitentiaire</title>

    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('dasher/dash/assets/images/favicon/favicon-32x32.png') }}" />
    <link rel="preconnect" href="https://fonts.googleapis.com/" />
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700;800&display=swap" />
    <link rel="stylesheet" href="{{ asset('dasher/dash/assets/libs/@tabler/icons-webfont/tabler-icons.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('dasher/dash/assets/css/theme.min.css') }}">

    <style>
        .prison-choice {
            border: 2px solid #e9ecef;
            border-radius: 0.5rem;
            padding: 1rem;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .prison-choice:hover {
            border-color: #624bff;
            background-color: #f8f7ff;
        }
        .prison-choice.selected {
            border-color: #624bff;
            background-color: #f0edff;
        }
        .prison-choice input {
            width: 1.1rem;
            height: 1.1rem;
            accent-color: #624bff;
        }
    </style>
</head>
<body>
    <main class="d-flex flex-column justify-content-center min-vh-100 bg-light">
        <section>
            <div class="container">
                {{-- En-tête avec logo et titre --}}
                <div class="row mb-6">
                    <div class="col-xl-4 offset-xl-4 col-md-12 col-12">
                        <div class="text-center">
                            <a class="fs-2 fw-bold d-flex align-items-center gap-2 justify-content-center mb-4 text-decoration-none text-dark" href="{{ route('login') }}">
                                <img src=""/>
                                <span>Suivi Pénitentiaire</span>
                            </a>
                            <h1 class="mb-1 fw-bold">Connexion</h1>
                            <p class="mb-0 text-muted">Accédez au tableau de bord de gestion des détenus</p>
                        </div>
                    </div>
                </div>

                <div class="row justify-content-center">
                    <div class="col-xl-5 col-lg-6 col-md-8 col-12">
                        <div class="card card-lg shadow-sm border-0">
                            <div class="card-body p-6">

                                {{-- Messages de statut ou d'erreur --}}
                                @if (session('status'))
                                    <div class="alert alert-success mb-4">{{ session('status') }}</div>
                                @endif

                                @if ($errors->any())
                                    <div class="alert alert-danger mb-4">
                                        <ul class="mb-0 ps-3">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <form method="POST" action="{{ route('login') }}">
                                    @csrf

                                    {{-- Champ email --}}
                                    <div class="mb-3">
                                        <label for="email" class="form-label">
                                            Adresse e-mail <span class="text-danger">*</span>
                                        </label>
                                        <input
                                            type="email"
                                            class="form-control @error('email') is-invalid @enderror"
                                            id="email"
                                            name="email"
                                            value="{{ old('email') }}"
                                            placeholder="exemple@penitentiaire.ml"
                                            required
                                            autofocus
                                            autocomplete="username"
                                        />
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- Champ mot de passe --}}
                                    <div class="mb-4">
                                        <label for="password" class="form-label">
                                            Mot de passe <span class="text-danger">*</span>
                                        </label>
                                        <div class="password-field position-relative">
                                            <input
                                                type="password"
                                                class="form-control fakePassword @error('password') is-invalid @enderror"
                                                id="password"
                                                name="password"
                                                placeholder="••••••••"
                                                required
                                                autocomplete="current-password"
                                            />
                                            <span class="position-absolute end-0 top-50 translate-middle-y me-3">
                                                <i class="ti ti-eye-off passwordToggler" style="cursor:pointer"></i>
                                            </span>
                                        </div>
                                        @error('password')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- Choix du type de prison (une seule case cochée à la fois) --}}
                                    <div class="mb-4">
                                        <label class="form-label d-block mb-2">
                                            Type d'établissement <span class="text-danger">*</span>
                                        </label>
                                        <p class="text-muted small mb-3">Cochez l'établissement auquel vous souhaitez accéder.</p>

                                        <input type="hidden" name="type_prison" id="type_prison" value="{{ old('type_prison') }}">

                                        <div class="row g-3">
                                            <div class="col-6">
                                                <label class="prison-choice d-flex align-items-center gap-3 mb-0 w-100 {{ old('type_prison') === 'homme' ? 'selected' : '' }}" id="choice-homme">
                                                    <input type="checkbox" id="prison_homme" {{ old('type_prison') === 'homme' ? 'checked' : '' }}>
                                                    <div>
                                                        <span class="fw-semibold d-block">Prison hommes</span>
                                                        <small class="text-muted">Établissement masculin

                                                        </small>
                                                    </div>
                                                </label>
                                            </div>
                                            <div class="col-6">
                                                <label class="prison-choice d-flex align-items-center gap-3 mb-0 w-100 {{ old('type_prison') === 'femme' ? 'selected' : '' }}" id="choice-femme">
                                                    <input type="checkbox" id="prison_femme" {{ old('type_prison') === 'femme' ? 'checked' : '' }}>
                                                    <div>
                                                        <span class="fw-semibold d-block">Prison femmes</span>
                                                        <small class="text-muted">Établissement féminin</small>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                        @error('type_prison')
                                            <div class="text-danger small mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- Se souvenir de moi --}}
                                    <div class="mb-4 d-flex align-items-center">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="remember_me" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="remember_me">Se souvenir de moi</label>
                                        </div>
                                    </div>

                                    {{-- Bouton de connexion --}}
                                    <div class="d-grid" style= background-color:#00A76F;>
                                        <button class="btn btn-primary btn-lg" type="submit">
                                            <i class="ti ti-login me-1"></i> Se connecter
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <p class="text-center text-muted small mt-4 mb-0">
                            Système de recensement et suivi des détenus — Gestion Pénitentiaire
                        </p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <script src="{{ asset('dasher/dash/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script>
        // Afficher / masquer le mot de passe
        document.querySelector('.passwordToggler')?.addEventListener('click', function () {
            const input = document.getElementById('password');
            const isPassword = input.type === 'password';
            input.type = isPassword ? 'text' : 'password';
            this.classList.toggle('ti-eye-off', !isPassword);
            this.classList.toggle('ti-eye', isPassword);
        });

        // Cases à cocher mutuellement exclusives pour le type de prison
        const hiddenInput = document.getElementById('type_prison');
        const checkHomme = document.getElementById('prison_homme');
        const checkFemme = document.getElementById('prison_femme');
        const choiceHomme = document.getElementById('choice-homme');
        const choiceFemme = document.getElementById('choice-femme');

        function selectPrison(type) {
            if (type === 'homme') {
                checkHomme.checked = true;
                checkFemme.checked = false;
                choiceHomme.classList.add('selected');
                choiceFemme.classList.remove('selected');
                hiddenInput.value = 'homme';
            } else if (type === 'femme') {
                checkFemme.checked = true;
                checkHomme.checked = false;
                choiceFemme.classList.add('selected');
                choiceHomme.classList.remove('selected');
                hiddenInput.value = 'femme';
            } else {
                checkHomme.checked = false;
                checkFemme.checked = false;
                choiceHomme.classList.remove('selected');
                choiceFemme.classList.remove('selected');
                hiddenInput.value = '';
            }
        }

        checkHomme.addEventListener('change', () => selectPrison(checkHomme.checked ? 'homme' : ''));
        checkFemme.addEventListener('change', () => selectPrison(checkFemme.checked ? 'femme' : ''));

        // Validation avant soumission : un type de prison doit être sélectionné
        document.querySelector('form').addEventListener('submit', function (e) {
            if (!hiddenInput.value) {
                e.preventDefault();
                alert('Veuillez cocher le type d\'établissement (prison hommes ou prison femmes).');
            }
        });
    </script>
</body>
</html>
