<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('infractions', function (Blueprint $table) {
            $table->id('id_infraction'); 
            $table->string('nature');          
            $table->string('type_infraction'); 
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('infractions');
    }
};