<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HoleStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('hole_statuses')->insert([
            ['name' => 'Covered'],
            ['name' => 'Uncovered'],
            ['name' => 'Fire Stopped'],
        ]);
    }
}
