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
        Schema::create('lieu', function (Blueprint $table) {
            $table->id('lieu_id');
            $table->string('adresse', 255)->nullable();
            $table->string('code_postal', 20)->nullable();
            $table->string('commune', 100)->nullable();
            $table->string('departement', 100)->nullable();
            $table->string('pays', 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lieu');
    }
};
