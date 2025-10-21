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
        Schema::create('club_competition', function (Blueprint $table) {
            $table->increments('club_competition_id');
            $table->timestamps();
            $table->unsignedInteger('club_id');
            $table->unsignedInteger('competition_id');
            $table->foreign('club_id')
                    ->references('club_id')
                    ->on('club')
                    ->onDelete('cascade')
                    ->onUpdate('restrict');
            $table->foreign('competition_id')
                    ->references('competition_id')
                    ->on('competition')
                    ->onDelete('cascade')
                    ->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('club_competition');
    }
};
