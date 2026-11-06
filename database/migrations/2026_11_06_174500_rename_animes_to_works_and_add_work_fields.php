<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::rename('animes', 'works');

        Schema::table('works', function (Blueprint $table) {
            $table->string('type')->default('anime');
            $table->string('slug')->nullable();
            $table->unsignedInteger('episodes')->nullable();
            $table->unsignedInteger('chapters')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('works', function (Blueprint $table) {
            $table->dropColumn(['type', 'slug', 'episodes', 'chapters']);
        });

        Schema::rename('works', 'animes');
    }
};
