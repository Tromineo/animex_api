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
        Schema::table('anime_categoria', function (Blueprint $table) {
            $table->softDeletes(); // cria a coluna deleted_at
        });
    }

    public function down(): void
    {
        Schema::table('animeCategoria', function (Blueprint $table) {
            $table->dropSoftDeletes(); // remove a coluna deleted_at
        });
    }
};
