<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MetaPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('meta_pages')->insert([[
            'title' => 'Hole Details',
            'question' => 'What is the hole specs?',
        ]]);
    }
}
