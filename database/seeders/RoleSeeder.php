<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'name' => 'Admin',
            'add_hole' => true,
            'update_hole' => true,
            'report_problem' => true,
            'replace_badge' => true,
            'create_report' => true,
            'insp_filter' => true,
            'ad_hoc_insp' => true,
        ]);
        DB::table('roles')->insert([
            'name' => 'Inspector',
            'insp_filter' => true,
            'ad_hoc_insp' => true,
            'update_hole' => true,
            'create_report' => true,
        ]);
        DB::table('roles')->insert([
            'name' => 'Driller',
            'add_hole' => true,
            'update_hole' => true,
            'report_problem' => true,
            'replace_badge' => true,
            'create_report' => true,
        ]);
        DB::table('roles')->insert([
            'name' => 'Other',
        ]);
    }
}
