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
        Schema::create('club_discipline', function (Blueprint $table) {
            $table->increments('club_discipline_id');
            $table->timestamps();
            $table->unsignedInteger('club_id');
            $table->unsignedInteger('discipline_id');
            $table->foreign('club_id')
                    ->references('club_id')
                    ->on('club')
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
        Schema::dropIfExists('club_discipline');
    }
};
