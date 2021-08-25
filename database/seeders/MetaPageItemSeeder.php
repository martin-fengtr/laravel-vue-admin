<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MetaPageItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('meta_page_items')->insert([
            ['page_id' => 1, 'item_id' => 1, 'order' => 1],
            ['page_id' => 1, 'item_id' => 2, 'order' => 2],
            ['page_id' => 1, 'item_id' => 3, 'order' => 3],
            ['page_id' => 1, 'item_id' => 4, 'order' => 4],
            ['page_id' => 1, 'item_id' => 5, 'order' => 5],
        ]);
    }
}
