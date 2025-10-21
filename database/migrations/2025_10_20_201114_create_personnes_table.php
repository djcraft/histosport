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
        Schema::create('personnes', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('nom')->nullable();
            $table->string('prenom')->nullable();
            $table->date('date_naissance')->nullable();
            $table->bigInteger('lieu_naissance')->nullable();
            $table->date('date_deces')->nullable();
            $table->string('lieu_deces')->nullable();
            $table->string('sexe')->nullable();
            $table->bigInteger('adresse')->nullable();

            $table->foreign('lieu_naissance')
                    ->references('lieu_id')
                    ->on('lieu')
                    ->onDelete('set null')
                    ->onUpdate('restrict');
            $table->foreign('lieu_deces')
                    ->references('lieu_id')
                    ->on('lieu')
                    ->onDelete('set null')
                    ->onUpdate('restrict');
            $table->foreign('adresse')
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
        Schema::dropIfExists('personnes');
    }
};
