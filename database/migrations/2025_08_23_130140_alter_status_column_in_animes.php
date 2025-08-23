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
        Schema::table('animes', function (Blueprint $table) {
            $table->renameColumn('status', 'id_status');
        });

        Schema::table('animes', function (Blueprint $table) {
            $table->integer('id_status')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('animes', function (Blueprint $table) {
            $table->renameColumn('id_status', 'status');
        });

        Schema::table('animes', function(Blueprint $table) {
            $table->string('status')->change();
        });
    }
};
