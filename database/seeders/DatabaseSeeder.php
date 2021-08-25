<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            RoleSeeder::class,
            ProjectStatusSeeder::class,
            HoleStatusSeeder::class,
            UserStatusSeeder::class,
            CompanySeeder::class,
            UserSeeder::class,
            ProjectSeeder::class,
            MetaElementSeeder::class,
            MetaItemSeeder::class,
            MetaPageSeeder::class,
            MetaPageItemSeeder::class,
            MetaAppSeeder::class,
        ]);
    }
}
