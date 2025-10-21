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
        Schema::create('club_source', function (Blueprint $table) {
            $table->increments('club_source_id');
            $table->timestamps();
            $table->unsignedInteger('club_id')->nullable();
            $table->unsignedInteger('source_id');
            $table->unsignedInteger('personne_id')->nullable();
            $table->unsignedInteger('competence_id')->nullable();
            $table->unsignedInteger('discipline_id')->nullable();
            $table->foreign('source_id')
                    ->references('source_id')
                    ->on('source')
                    ->onDelete('cascade')
                    ->onUpdate('restrict');
            $table->foreign('club_id')
                    ->references('club_id')
                    ->on('club')
                    ->onDelete('cascade')
                    ->onUpdate('restrict');
            $table->foreign('personne_id')
                    ->references('personne_id')
                    ->on('personne')
                    ->onDelete('cascade')
                    ->onUpdate('restrict');
            $table->foreign('competence_id')
                    ->references('competence_id')
                    ->on('competence')
                    ->onDelete('cascade')
                    ->onUpdate('restrict');
            $table->foreign('discipline_id')
                    ->references('discipline_id')
                    ->on('discipline')
                    ->onDelete('cascade')
                    ->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('club_source');
    }
};
