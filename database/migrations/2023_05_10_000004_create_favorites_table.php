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
        // Desabilita a verificação de chaves estrangeiras durante esta migration
        Schema::disableForeignKeyConstraints();

        Schema::create('favorites', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('anime_id');
            $table->timestamp('created_at')->useCurrent();
            
            $table->unique(['user_id', 'anime_id']);
            
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
                  
            $table->foreign('anime_id')
                  ->references('id')
                  ->on('animes')
                  ->onDelete('cascade');
        });

        // Habilita novamente a verificação de chaves estrangeiras
        Schema::enableForeignKeyConstraints();
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('favorites');
    }
};