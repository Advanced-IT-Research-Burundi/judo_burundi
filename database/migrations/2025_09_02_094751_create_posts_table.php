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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->text('contenu');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('typepost_id')->constrained('type_posts')->onDelete('cascade');
            $table->timestamp('date_post');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('posts');
    }
};
