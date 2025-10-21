<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('competition_participant', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('competition_id');
            $table->unsignedBigInteger('club_id')->nullable();
            $table->unsignedBigInteger('personne_id')->nullable();
            $table->string('resultat', 100)->nullable();
            $table->unsignedBigInteger('source_id')->nullable();
            $table->timestamps();
            $table->foreign('competition_id')->references('competition_id')->on('competitions')->onDelete('cascade');
            $table->foreign('club_id')->references('club_id')->on('clubs')->onDelete('cascade');
            $table->foreign('personne_id')->references('personne_id')->on('personnes')->onDelete('cascade');
            $table->foreign('source_id')->references('source_id')->on('sources')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('competition_participant');
    }
};
