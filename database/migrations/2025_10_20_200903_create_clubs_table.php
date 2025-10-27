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
        Schema::create('clubs', function (Blueprint $table) {
            $table->id('club_id');
            $table->string('nom', 255);
            $table->string('nom_origine', 255)->nullable();
            $table->string('surnoms', 255)->nullable();
            $table->string('date_fondation', 10)->nullable();
            $table->string('date_fondation_precision', 10)->nullable();
            $table->string('date_disparition', 10)->nullable();
            $table->string('date_disparition_precision', 10)->nullable();
            $table->string('date_declaration', 10)->nullable();
            $table->string('date_declaration_precision', 10)->nullable();
            $table->string('acronyme', 50)->nullable();
            $table->string('couleurs', 100)->nullable();
            $table->unsignedBigInteger('siege_id')->nullable();
            $table->longText('notes')->nullable();
            $table->timestamps();

            $table->foreign('siege_id')
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
        Schema::dropIfExists('clubs');
    }
};
