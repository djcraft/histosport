<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('historisations', function (Blueprint $table) {
            $table->id();
            $table->string('entity_type', 50); // ex: club, personne, discipline, competition
            $table->unsignedBigInteger('entity_id');
            $table->unsignedBigInteger('utilisateur_id')->nullable();
            $table->string('action', 50); // création, modification, suppression
            $table->json('donnees_avant')->nullable();
            $table->json('donnees_apres')->nullable();
            $table->timestamp('date')->useCurrent();
            $table->timestamps();

            $table->foreign('utilisateur_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('historisations');
    }
};
