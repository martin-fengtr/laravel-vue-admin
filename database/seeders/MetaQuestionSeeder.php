<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MetaItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('meta_items')->insert([[
            'element_id' => 1,
            'label' => 'Gridline',
            'order' => 1,
            'required' => true,
        ]]);
    }
}
