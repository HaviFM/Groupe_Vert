<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Ajoute des rôles par défaut
        Role::create(['name' => 'Utilisateur']);
        Role::create(['name' => 'Admin']);
    }
}
