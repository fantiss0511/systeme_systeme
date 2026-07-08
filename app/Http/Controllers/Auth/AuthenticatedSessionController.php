<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * Gère la connexion et la déconnexion des utilisateurs.
 */
class AuthenticatedSessionController extends Controller
{
    /** Affiche la page de connexion. */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Traite la connexion : authentifie l'utilisateur, enregistre le type de prison
     * en session et redirige vers le tableau de bord admin.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Mémorise le type d'établissement choisi (homme ou femme) pour filtrer les données
        $request->session()->put('type_prison', $request->input('type_prison'));

        return redirect()->intended(route('admin.dashboard', absolute: false));
    }

    /** Déconnecte l'utilisateur et supprime les données de session. */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
