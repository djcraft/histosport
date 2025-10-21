<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('entity_source', function (Blueprint $table) {
            $table->id();
            $table->string('entity_type', 50); // ex: club, personne, discipline, competition
            $table->unsignedBigInteger('entity_id');
            $table->unsignedBigInteger('source_id');
            $table->date('date_source')->nullable();
            $table->text('commentaire')->nullable();
            $table->timestamps();

            $table->foreign('source_id')->references('source_id')->on('sources')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('entity_source');
    }
};
