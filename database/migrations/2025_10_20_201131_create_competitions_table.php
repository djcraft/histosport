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
        Schema::create('competitions', function (Blueprint $table) {
            $table->id('competition_id');
            $table->string('nom', 255);
            $table->date('date')->nullable();
            $table->unsignedBigInteger('lieu_id')->nullable();
            $table->unsignedBigInteger('organisateur_club_id')->nullable();
            $table->unsignedBigInteger('organisateur_personne_id')->nullable();
            $table->string('type', 100)->nullable();
            $table->string('duree', 50)->nullable();
            $table->string('niveau', 100)->nullable();
            $table->timestamps();

            $table->foreign('lieu_id')
                ->references('lieu_id')
                ->on('lieu')
                ->onDelete('set null')
                ->onUpdate('restrict');
            $table->foreign('organisateur_club_id')
                ->references('club_id')
                ->on('clubs')
                ->onDelete('set null')
                ->onUpdate('restrict');
            $table->foreign('organisateur_personne_id')
                ->references('personne_id')
                ->on('personnes')
                ->onDelete('set null')
                ->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('competitions');
    }
};
