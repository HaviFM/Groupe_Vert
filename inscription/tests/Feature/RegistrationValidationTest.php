<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegistrationValidationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Teste si un administrateur peut approuver l'inscription d'un utilisateur.
     */
    #[\PHPUnit\Framework\Attributes\Test]
    public function it_can_approve_user_registration()
    {
        // Créer un utilisateur en attente de validation
        $user = User::factory()->create(['statut' => 'en_attente']);

        // Créer un administrateur
        $admin = User::factory()->create(['role_id' => 2]);

        // Simuler l'action de l'administrateur pour approuver l'utilisateur
        $response = $this->actingAs($admin)->put('/admin/inscriptions/update-multiple', [
            'users' => [
                $user->id => ['statut' => 'validé', 'role' => 1],
            ],
        ]);

        // Vérifier que l'utilisateur a bien été approuvé (statut = 'validé')
        $this->assertDatabaseHas('users', ['id' => $user->id, 'statut' => 'validé']);
        $response->assertStatus(302); // Assurer que la redirection s'est bien passée
    }

    /**
     * Teste qu'il n'est pas possible d'approuver un utilisateur inexistant.
     */
    #[\PHPUnit\Framework\Attributes\Test]
    public function it_cannot_approve_non_existing_user()
    {
        // Créer un administrateur
        $admin = User::factory()->create(['role_id' => 2]);

        // Tenter de mettre à jour un utilisateur inexistant
        $response = $this->actingAs($admin)->put('/admin/inscriptions/update-multiple', [
            'users' => [
                9999 => ['statut' => 'validé', 'role' => 1], // Utilisateur inexistant avec un ID arbitraire
            ],
        ]);

        // Vérifier que la réponse retourne un code 404 (utilisateur non trouvé)
        $response->assertStatus(404);
    }

    /**
     * Teste si la base de données utilisée pour les tests est bien la base de données de test.
     */
    #[\PHPUnit\Framework\Attributes\Test]
    public function it_displays_the_database_used()
    {
        // Récupérer le nom de la base de données en cours
        $databaseName = \DB::connection()->getDatabaseName();
        
        // Afficher le nom de la base de données utilisée dans la console (utile pour le debug)
        echo "\nDatabase currently being used: " . $databaseName . "\n";

        // Vérifier que c'est bien la base de données de test (groupe_vert_test)
        $this->assertEquals('groupe_vert_test', $databaseName);
    }

    /**
     * Teste que les utilisateurs non administrateurs ne peuvent pas approuver d'autres utilisateurs.
     */
    #[\PHPUnit\Framework\Attributes\Test]
    public function non_admin_users_cannot_approve_users()
    {
        // Créer un utilisateur non-admin
        $nonAdmin = User::factory()->create(['role_id' => 1]);

        // Créer un utilisateur en attente de validation
        $user = User::factory()->create(['statut' => 'en_attente']);

        // Simuler l'action de validation par un utilisateur non-admin
        $response = $this->actingAs($nonAdmin)->put('/admin/inscriptions/update-multiple', [
            'users' => [
                $user->id => ['statut' => 'validé', 'role' => 1],
            ],
        ]);

        // Vérifier que l'accès est refusé (403 Forbidden)
        $response->assertStatus(403);
    }

    /**
     * Teste la suppression douce (soft delete) d'un utilisateur.
     */
    #[\PHPUnit\Framework\Attributes\Test]
    public function it_can_soft_delete_users()
    {
        // Créer un utilisateur en attente de validation
        $user = User::factory()->create(['statut' => 'en_attente']);

        // Créer un administrateur
        $admin = User::factory()->create(['role_id' => 2]);

        // Simuler la suppression douce de l'utilisateur
        $response = $this->actingAs($admin)->put('/admin/inscriptions/update-multiple', [
            'users' => [
                $user->id => ['delete' => 1], // Suppression avec 'delete' défini à 1
            ],
        ]);

        // Vérifier que l'utilisateur a bien été soft deleted
        $this->assertSoftDeleted('users', ['id' => $user->id]);

        // Vérifier que la redirection s'est bien passée
        $response->assertStatus(302);
    }
}
