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
        Schema::create('club_personne', function (Blueprint $table) {
            $table->increments('club_personne_id');
            $table->timestamps();
            $table->unsignedInteger('club_id');
            $table->unsignedInteger('personne_id');
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
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('club_personne', function (Blueprint $table) {
            $table->dropForeign(['club_id']);
            $table->dropForeign(['personne_id']);
        });

        Schema::dropIfExists('club_personne');
    }
};
