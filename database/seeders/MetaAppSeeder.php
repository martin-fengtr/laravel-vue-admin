<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MetaAppSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('meta_apps')->insert([
            ['role_id' => 3, 'page_id' => 1, 'order' => 1],
            ['role_id' => 2, 'page_id' => 1, 'order' => 1],
        ]);
    }
}
