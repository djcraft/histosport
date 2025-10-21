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
        Schema::create('discipline_personne', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->bigInteger('discipline_id')->unsigned();
            $table->bigInteger('personne_id')->unsigned();
            $table->foreign('discipline_id')
                    ->references('discipline_id')
                    ->on('discipline')
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
        Schema::dropIfExists('discipline_personne');
    }
};
