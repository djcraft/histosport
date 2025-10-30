<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('competition_lieu', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('competition_id');
            $table->unsignedBigInteger('lieu_id');
            $table->string('type', 100)->nullable(); // ex: site principal, annexe
            $table->integer('ordre')->nullable(); // pour l'ordre chronologique ou d'importance
            $table->timestamps();
            $table->foreign('competition_id')->references('competition_id')->on('competitions')->onDelete('cascade');
            $table->foreign('lieu_id')->references('lieu_id')->on('lieu')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('competition_lieu');
    }
};
