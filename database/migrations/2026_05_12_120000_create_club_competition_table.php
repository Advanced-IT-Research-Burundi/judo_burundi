<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Clubs additionnels participant à une compétition (en plus des clubs domicile / adversaire).
     */
    public function up(): void
    {
        Schema::create('club_competition', function (Blueprint $table) {
            $table->id();
            $table->foreignId('competition_id')->constrained('competitions')->cascadeOnDelete();
            $table->foreignId('club_id')->constrained('clubs')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['competition_id', 'club_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('club_competition');
    }
};
