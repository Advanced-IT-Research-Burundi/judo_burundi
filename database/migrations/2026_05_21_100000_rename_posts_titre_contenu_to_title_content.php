<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Aligne une base existante (colonnes titré / contenu) sur la migration canonique posts (title / content).
 */
return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('posts')) {
            return;
        }

        $driver = Schema::getConnection()->getDriverName();

        if (Schema::hasColumn('posts', 'titre') && ! Schema::hasColumn('posts', 'title')) {
            if ($driver === 'mysql') {
                DB::statement('ALTER TABLE `posts` CHANGE `titre` `title` VARCHAR(255) NOT NULL');
            } else {
                Schema::table('posts', function (Blueprint $table) {
                    $table->renameColumn('titre', 'title');
                });
            }
        }

        if (Schema::hasColumn('posts', 'contenu') && ! Schema::hasColumn('posts', 'content')) {
            if ($driver === 'mysql') {
                // Contenu souvent TEXT ; NULL autorisé si ancienne base nullable
                DB::statement('ALTER TABLE `posts` CHANGE `contenu` `content` TEXT NOT NULL');
            } else {
                Schema::table('posts', function (Blueprint $table) {
                    $table->renameColumn('contenu', 'content');
                });
            }
        }
    }

    public function down(): void
    {
        if (! Schema::hasTable('posts')) {
            return;
        }

        $driver = Schema::getConnection()->getDriverName();

        if (Schema::hasColumn('posts', 'title') && ! Schema::hasColumn('posts', 'titre')) {
            if ($driver === 'mysql') {
                DB::statement('ALTER TABLE `posts` CHANGE `title` `titre` VARCHAR(255) NOT NULL');
            } else {
                Schema::table('posts', function (Blueprint $table) {
                    $table->renameColumn('title', 'titre');
                });
            }
        }

        if (Schema::hasColumn('posts', 'content') && ! Schema::hasColumn('posts', 'contenu')) {
            if ($driver === 'mysql') {
                DB::statement('ALTER TABLE `posts` CHANGE `content` `contenu` TEXT NOT NULL');
            } else {
                Schema::table('posts', function (Blueprint $table) {
                    $table->renameColumn('content', 'contenu');
                });
            }
        }
    }
};
