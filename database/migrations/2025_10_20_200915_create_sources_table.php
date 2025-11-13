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
        Schema::create('sources', function (Blueprint $table) {
            $table->id('source_id');
            $table->string('titre', 255);
            $table->string('auteur', 255)->nullable();
            $table->string('annee_reference', 10)->nullable();
            $table->string('type', 100)->nullable();
            $table->string('cote', 100)->nullable();
            $table->unsignedBigInteger('lieu_edition_id')->nullable();
            $table->unsignedBigInteger('lieu_conservation_id')->nullable();
            $table->unsignedBigInteger('lieu_couverture_id')->nullable();
            $table->string('url', 255)->nullable();
            $table->timestamps();

            $table->foreign('lieu_edition_id')->references('lieu_id')->on('lieu')->onDelete('set null');
            $table->foreign('lieu_conservation_id')->references('lieu_id')->on('lieu')->onDelete('set null');
            $table->foreign('lieu_couverture_id')->references('lieu_id')->on('lieu')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sources');
    }
};
