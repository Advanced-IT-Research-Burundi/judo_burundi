<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('gallery_images', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->string('images'); // Chemin vers l'image
            $table->string('alt_text')->nullable(); // Texte alternatif pour l'accessibilité
            $table->integer('ordre')->default(0); // Pour trier les images
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('gallery_images');
    }
};