<?php

use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\AuditController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InfractionController;
use App\Http\Controllers\MedicaleController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Page d'accueil
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('admin.dashboard');
    }

    return redirect()->route('login');
});

// Routes d'authentification
require __DIR__.'/auth.php';

// Profil utilisateur
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Tableau de bord et pages admin
Route::middleware('auth')->group(function () {

    Route::get('/dashboard', function () {
        return redirect()->route('admin.dashboard');
    })->name('dashboard');

    Route::get('/dashboard/admin', [DashboardController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/dashboard/admin/detenue/search', [DashboardController::class, 'search'])->name('admin.search');
    Route::get('/dashboard/admin/sortie/listes', [DashboardController::class, 'sortieListes'])->name('admin.sortie.listes');
    Route::get('/dashboard/admin/deces/listes', [DashboardController::class, 'decesListes'])->name('admin.deces.listes');

    // Formulaire d'affichage du formulaire (GET)
    Route::get('/dashboard/admin/detenue/create', [DashboardController::class, 'create'])->name('admin.detenus.create');
    Route::post('/dashboard/admin/detenue/store', [DashboardController::class, 'store'])->name('admin.detenus.store');
    Route::get('/dashboard/admin/detenue/show/{detenu}', [DashboardController::class, 'show'])->name('admin.detenus.show');
    Route::get('/dashboard/admin/detenue/edit/{detenu}', [DashboardController::class, 'edit'])->name('admin.detenus.edit');
    Route::put('/dashboard/admin/detenue/update/{detenu}', [DashboardController::class, 'update'])->name('admin.detenus.update');
    Route::delete('/dashboard/admin/detenue/destroy/{detenu}', [DashboardController::class, 'destroy'])->name('admin.detenus.destroy');

    Route::prefix('admin')->group(function () {
        // Routes pour Infractions
        Route::get('/infractions', [InfractionController::class, 'index'])->name('admin.infraction.index');
        Route::get('/infractions/create', [InfractionController::class, 'create'])->name('admin.infraction.create');
        Route::post('/infractions', [InfractionController::class, 'store'])->name('admin.infraction.store');
        Route::delete('/infractions/{id_infraction}', [InfractionController::class, 'destroy'])->name('admin.infraction.destroy');

        // Routes pour Juridictions
        Route::get('/juridictions', [DashboardController::class, 'indexJuridiction'])->name('admin.juridiction.index');
        Route::get('/juridictions/create', [DashboardController::class, 'createJuridiction'])->name('admin.juridiction.create');
        Route::post('/juridictions', [DashboardController::class, 'storeJuridiction'])->name('admin.juridiction.store');
        Route::delete('/juridictions/{id_juridiction}', [DashboardController::class, 'destroyJuridiction'])->name('admin.juridiction.destroy');
    });

    Route::get('/admin/infractions/types', [DashboardController::class, 'typesInfraction'])->name('admin.infraction.types');

    Route::get('/admin/archive', [ArchiveController::class, 'archive'])->name('admin.archive');
    Route::get('/admin/archive/create', [ArchiveController::class, 'create'])->name('admin.archive.create');
    Route::get('/admin/audit', [AuditController::class, 'audit'])->name('admin.audit');
    Route::get('/admin/medicale', [MedicaleController::class, 'medicale'])->name('admin.medicale');
    Route::get('/admin/medicale/create', [MedicaleController::class, 'create'])->name('admin.medicale.create');
});
