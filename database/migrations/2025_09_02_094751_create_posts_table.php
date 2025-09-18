<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->text('contenu');
            $table->string('image')->nullable();
            $table->string('titre');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('typepost_id')->constrained('type_posts')->onDelete('cascade');
            $table->timestamp('date_post');
            $table->string('lieu_evenement')->nullable(); 
            $table->datetime('date_evenement_debut')->nullable();
            $table->datetime('date_evenement_fin')->nullable();
            $table->string('niveau_competition')->nullable(); 
            $table->text('resultats')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('posts');
    }
};
