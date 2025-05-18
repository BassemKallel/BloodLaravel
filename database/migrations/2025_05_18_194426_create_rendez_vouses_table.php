<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rendez_vous', function (Blueprint $table) {
            $table->id();
            $table->date('dateRendezVous')->nullable();
            $table->date('dernierRendezVous')->nullable();
            $table->string('status')->default('Confirmé');
            $table->foreignId('id_donneur');
            $table->foreignId('id_centre');
            $table->foreign('id_donneur')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_centre')->references('id')->on('centres')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rendez_vouses');
    }
};
