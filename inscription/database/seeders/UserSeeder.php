<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
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
        User::create([
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'password' => Hash::make('password'),
            'statut' => 'en_attente'
        ]);

        User::create([
            'name' => 'Jane Smith',
            'email' => 'jane.smith@example.com',
            'password' => Hash::make('password'),
            'statut' => 'validé'
        ]);

        User::create([
            'name' => 'Alex Brown',
            'email' => 'alex.brown@example.com',
            'password' => Hash::make('password'),
            'statut' => 'refusé'
        ]);
    }
}
