<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    public function up(): void
    {
        Schema::create('condamnations', function (Blueprint $table) {
            $table->id('id_condamnation');
            $table->string('matricule_detenu', 30);
            $table->unsignedBigInteger('id_infraction');
            $table->unsignedBigInteger('id_juridiction');
            $table->date('date_debut_peine');
            $table->unsignedInteger('duree_peine_mois');
            $table->date('fin_peine'); 
            $table->timestamps();

            // Suppression en cascade 
            $table->foreign('matricule_detenu')
                ->references('matricule_ou_nina')
                ->on('detenus')
                ->cascadeOnDelete();

        
            $table->foreign('id_infraction')
                ->references('id_infraction')
                ->on('infractions')
                ->cascadeOnDelete(); 

            $table->foreign('id_juridiction')
                ->references('id_juridiction')
                ->on('juridictions')
                ->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('condamnations');
    }
};