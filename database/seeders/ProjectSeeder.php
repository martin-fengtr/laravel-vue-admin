<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('projects')->insert([[
            'company_id' => 1,
            'user_id' => 2,
            'status_id' => 1,
            'name' => 'Project 1',
            'hash' => 'jsahgdasd54NHgsa',
        ]]);
    }
}
