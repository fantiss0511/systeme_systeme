<?php
use App\Http\Controllers\CondamnationController;
use App\Http\Controllers\DetenuController;
use App\Http\Controllers\PingController;
use App\Http\Controllers\ReferentielController;
use App\Http\Controllers\StatistiqueController;
use Illuminate\Support\Facades\Route;

// Test  Swagger
Route::get('ping', PingController::class);


 Route::get('detenus/listes/presents', [DetenuController::class, 'presents']);
 Route::get('detenus/listes/sorties-prevues', [DetenuController::class, 'sortiesPrevues']);
 Route::get('detenus/listes/deces', [DetenuController::class, 'deces']);


 Route::apiResource('detenus', DetenuController::class);


 Route::get('detenus/{detenu}/condamnations', [CondamnationController::class, 'index']);
 Route::post('detenus/{detenu}/condamnations', [CondamnationController::class, 'store']);


 Route::get('condamnations/{condamnation}', [CondamnationController::class, 'show']);
 Route::put('condamnations/{condamnation}', [CondamnationController::class, 'update']);
 Route::patch('condamnations/{condamnation}', [CondamnationController::class, 'update']);
 Route::delete('condamnations/{condamnation}', [CondamnationController::class, 'destroy']);


 Route::get('statistiques/par-infraction', [StatistiqueController::class, 'parInfraction']);
 Route::get('statistiques/par-age', [StatistiqueController::class, 'parAge']);


 Route::get('infractions', [ReferentielController::class, 'infractions']);
 Route::get('juridictions', [ReferentielController::class, 'juridictions']);
