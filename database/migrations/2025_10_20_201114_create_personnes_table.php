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
        Schema::create('personnes', function (Blueprint $table) {
            $table->id('personne_id');
            $table->string('nom', 255);
            $table->string('prenom', 255)->nullable();
            $table->string('date_naissance', 10)->nullable();
            $table->string('date_naissance_precision', 10)->nullable();
            $table->unsignedBigInteger('lieu_naissance_id')->nullable();
            $table->string('date_deces', 10)->nullable();
            $table->string('date_deces_precision', 10)->nullable();
            $table->unsignedBigInteger('lieu_deces_id')->nullable();
            $table->string('sexe', 10)->nullable();
            $table->string('titre', 100)->nullable();
            $table->unsignedBigInteger('adresse_id')->nullable();
            $table->timestamps();

            $table->foreign('lieu_naissance_id')
                ->references('lieu_id')
                ->on('lieu')
                ->onDelete('set null')
                ->onUpdate('restrict');
            $table->foreign('lieu_deces_id')
                ->references('lieu_id')
                ->on('lieu')
                ->onDelete('set null')
                ->onUpdate('restrict');
            $table->foreign('adresse_id')
                ->references('lieu_id')
                ->on('lieu')
                ->onDelete('set null')
                ->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personnes');
    }
};
