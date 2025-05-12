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
        // Verificamos se as tabelas necessárias existem
        if (Schema::hasTable('animes') && Schema::hasTable('genres')) {
            Schema::create('anime_genres', function (Blueprint $table) {
                $table->unsignedBigInteger('anime_id');
                $table->unsignedBigInteger('genre_id');
                
                $table->primary(['anime_id', 'genre_id']);
                
                $table->foreign('anime_id')
                      ->references('id')
                      ->on('animes')
                      ->onDelete('cascade');
                      
                $table->foreign('genre_id')
                      ->references('id')
                      ->on('genres')
                      ->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anime_genres');
    }
};