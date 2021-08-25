<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'username' => 'Admin',
            'first_name' => 'Admin',
            'last_name' => 'Admin',
            'email' => 'admmin@holewise.com',
            'password' => Hash::make('JHnd$34!#@'),
            'role_id' => 1,
        ]);
        DB::table('users')->insert([
            'username' => 'user1',
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => 'user@holewise.com',
            'password' => Hash::make('123456789'),
            'company_id' => 1,
            'status_id' => 1,
            'role_id' => 3,
        ]);
    }
}
