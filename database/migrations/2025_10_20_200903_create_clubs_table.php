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
        Schema::create('club', function (Blueprint $table) {
            $table->increments('club_id');
            $table->timestamps();
            $table->string('nom', 255);
            $table->date('fondation')->nullable();
            $table->date('disparition')->nullable();
            $table->date('declaration')->nullable();
            $table->longText('notes')->nullable();
            $table->unsignedInteger('siege')->nullable();
            $table->foreign('siege')
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
        Schema::dropIfExists('club');
    }
};
