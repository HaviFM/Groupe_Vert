<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\UserSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Appelle des seeders pour rôles et utilisateurs
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
        ]);
    }
}
