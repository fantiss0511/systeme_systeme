<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration : table des juridictions (référentiel).
 * Doit être exécutée avant condamnations (clé étrangère).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('juridictions', function (Blueprint $table) {
            $table->id('id_juridiction');
            $table->string('nom');           // Ex : Tribunal de Grande Instance de Bamako
            $table->string('ville')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('juridictions');
    }
};
