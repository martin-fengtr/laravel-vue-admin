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
        DB::table('meta_items')->insert([
            [
                'element_id' => 1,
                'label' => 'Diameter',
                'order' => 1,
                'required' => true,
            ], [
                'element_id' => 1,
                'label' => 'Length',
                'order' => 2,
                'required' => true,
            ], [
                'element_id' => 1,
                'label' => 'Width',
                'order' => 3,
                'required' => true,
            ], [
                'element_id' => 1,
                'label' => 'Height',
                'order' => 4,
                'required' => true,
            ],
        ]);
        DB::table('meta_items')->insert([[
            'element_id' => 3,
            'label' => 'Orientation',
            'order' => 5,
            'required' => true,
            'options' => json_encode(['Floor', 'Wall', 'Soffit']),
        ]]);
    }
}
