<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration : table des détenus (informations personnelles).
 * Clé primaire = numéro Nina (identifiant national, non auto-généré).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detenus', function (Blueprint $table) {
            $table->string('matricule_ou_nina', 30)->primary();
            $table->string('nom');
            $table->string('prenom');
            $table->date('date_naissance');
            $table->enum('sexe', ['M', 'F']);
            $table->string('photo')->nullable();
            $table->enum('statut', ['present', 'libere', 'decede'])->default('present');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detenus');
    }
};
