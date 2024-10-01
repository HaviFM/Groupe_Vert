<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => bcrypt('password'), // Utilise un mot de passe par défaut
            'remember_token' => Str::random(10),
            'role_id' => 1, // Par défaut, rôle utilisateur normal
            'statut' => 'en_attente', // Statut par défaut
        ];
    }

    // Définir un état pour créer un administrateur
    public function admin()
    {
        return $this->state(function (array $attributes) {
            return [
                'role_id' => 2, // Rôle admin avec role_id = 2
            ];
        });
    }
}
