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
        Schema::create('competitions', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('lieu')->nullable();
            $table->string('type')->nullable();
            $table->string('description')->nullable();
            $table->string('saison')->nullable();
            $table->date('date_competition')->nullable();
            $table->string('resultat')->nullable();
            $table->foreignId('clubdomicil_id')->constrained('clubs')->onDelete('cascade');
            $table->foreignId('clubadversaire_id')->constrained('clubs')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('competitions');
    }
};
