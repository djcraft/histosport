<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Table pivot discipline_personne
        Schema::create('discipline_personne', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('discipline_id');
            $table->unsignedBigInteger('personne_id');
            $table->timestamps();
            $table->foreign('discipline_id')->references('discipline_id')->on('disciplines')->onDelete('cascade');
            $table->foreign('personne_id')->references('personne_id')->on('personnes')->onDelete('cascade');
        });
    
        // Table pivot club_personne
        Schema::create('club_personne', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('club_id');
            $table->unsignedBigInteger('personne_id');
            $table->string('role', 100)->nullable(); // ex: membre, dirigeant
            $table->date('date_debut')->nullable();
            $table->date('date_fin')->nullable();
            $table->timestamps();
            $table->foreign('club_id')->references('club_id')->on('clubs')->onDelete('cascade');
            $table->foreign('personne_id')->references('personne_id')->on('personnes')->onDelete('cascade');
        });

        // Table pivot club_discipline
        Schema::create('club_discipline', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('club_id');
            $table->unsignedBigInteger('discipline_id');
            $table->timestamps();
            $table->foreign('club_id')->references('club_id')->on('clubs')->onDelete('cascade');
            $table->foreign('discipline_id')->references('discipline_id')->on('disciplines')->onDelete('cascade');
        });

        // Table pivot club_lieu (lieux utilisés par le club)
        Schema::create('club_lieu', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('club_id');
            $table->unsignedBigInteger('lieu_id');
            $table->string('type', 100)->nullable(); // ex: site d'entraînement, stade
            $table->timestamps();
            $table->foreign('club_id')->references('club_id')->on('clubs')->onDelete('cascade');
            $table->foreign('lieu_id')->references('lieu_id')->on('lieu')->onDelete('cascade');
        });

        // Table pivot club_section (sous-clubs)
        Schema::create('club_section', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('club_id');
            $table->unsignedBigInteger('section_id');
            $table->timestamps();
            $table->foreign('club_id')->references('club_id')->on('clubs')->onDelete('cascade');
            $table->foreign('section_id')->references('club_id')->on('clubs')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('discipline_personne');
        Schema::dropIfExists('club_personne');
        Schema::dropIfExists('club_discipline');
        Schema::dropIfExists('club_lieu');
        Schema::dropIfExists('club_section');
    }
};
