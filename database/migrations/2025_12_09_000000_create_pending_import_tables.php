<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('pending_imports', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // ex: club, competition, etc.
            $table->string('status')->default('pending'); // pending, validated, rejected
            $table->json('meta')->nullable(); // infos complémentaires (utilisateur, etc.)
            $table->timestamps();
        });

        Schema::create('pending_import_entities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pending_import_id')->constrained('pending_imports')->onDelete('cascade');
            $table->string('entity_type'); // club, personne, etc.
            $table->json('data'); // Données normalisées de l'entité
            $table->string('hash')->index(); // Hash canonique pour détection des doublons
            $table->string('sheet_name')->nullable(); // Feuille Excel d'origine
            $table->unsignedInteger('row_number')->nullable(); // Ligne d'origine
            $table->string('status')->default('pending'); // pending, conflict, validated, rejected
            $table->json('conflicts')->nullable(); // Conflits détectés
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pending_import_entities');
        Schema::dropIfExists('pending_imports');
    }
};
