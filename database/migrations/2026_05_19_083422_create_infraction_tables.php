<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration : table des infractions (référentiel).
 * Doit être exécutée avant condamnations (clé étrangère).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('infractions', function (Blueprint $table) {
            $table->id('id_infraction');
            $table->string('nature');          // Ex : Vol simple
            $table->string('type_infraction'); // Ex : Atteinte aux biens
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('infractions');
    }
};
