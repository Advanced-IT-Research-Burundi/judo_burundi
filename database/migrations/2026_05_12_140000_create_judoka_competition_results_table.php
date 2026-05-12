<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('judoka_competition_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('competition_id')->constrained('competitions')->cascadeOnDelete();
            $table->foreignId('joueur_id')->constrained('joueurs')->cascadeOnDelete();
            $table->unsignedSmallInteger('placement')->nullable()->comment('Classement (1, 2, 3, 5, 7...)');
            $table->string('medal', 16)->nullable()->comment('gold, silver, bronze ou vide');
            $table->string('categorie_label', 120)->nullable()->comment('ex: Hommes -60 kg');
            $table->string('pays_code', 8)->nullable()->comment('Code pays affiché (ex: BDI)');
            $table->timestamps();

            $table->index(['competition_id', 'categorie_label']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('judoka_competition_results');
    }
};
