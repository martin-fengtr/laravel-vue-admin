<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MetaElementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('meta_elements')->insert([
            ['name' => 'Text Field', 'value_type' => 'string'],
            ['name' => 'Switch', 'value_type' => 'boolean'],
            ['name' => 'Select', 'value_type' => 'array'],
        ]);
    }
}
