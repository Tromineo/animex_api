<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('status')->insert([
            'nome' => 'Em andamento'
        ]);

        DB::table('status')->insert([
            'nome' => 'Finalizado'
        ]);

        DB::table('status')->insert([
            'nome' => 'Cancelado'
        ]);

        DB::table('status')->insert([
            'nome' => 'Hiato'
        ]);
    }
}
