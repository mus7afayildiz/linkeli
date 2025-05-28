<?php
/**
 * ETML
 * Auteur      : Mustafa Yildiz
 * Date        : 22.05.2025
 * Description : 
 */

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Link;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LinkFeatureTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }


    use RefreshDatabase;


    public function test_link_creation_without_password()
    {
       // Création d'un utilisateur et connexion
       $user = User::factory()->create();
       $this->actingAs($user);

       // Une requête POST est en cours
       $response = $this->post('/links/store', [
           'lienDeSource' => 'https://example.com',
       ]);

       // La réponse a-t-elle réussi ?
       $response->assertRedirect('/dashboard');

       // La vérification de la base de données est effectuée
       $this->assertDatabaseHas('links', [
           'source_link' => 'https://example.com',
       ]);
    }


    public function test_link_creation_with_password()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post('/links/store', [
                'lienDeSource' => 'https://secure.com',
                'motDePasse' => 'secret123',
            ]);

        $this->assertDatabaseHas('links', [
            'source_link' => 'https://secure.com',
            'password_protected' => 1,
        ]);
    }

    public function test_redirects_after_correct_password()
    {
        $user = User::factory()->create();
        $link = Link::factory()->create([
            'source_link' => 'https://secure.com',
            'shortcut_link' => 'abcd12',
            'password_protected' => 1,
            'password_hash' => Hash::make('pass')
        ]);

        $this->actingAs($user)
        ->post("/{$link->shortcut_link}/verify", [
            'lienDeSource' => 'https://secure.com',
            'password' => 'pass'
        ])
        ->assertRedirect($link->source_link);
    }

    public function test_counter_increments_on_each_click()
    {
        $user = User::factory()->create();
        $link = Link::factory()->create([
            'counter' => 0,
            'password_protected' => 0
        ]);

        $this->get("/{$link->shortcut_link}");
        $this->get("/{$link->shortcut_link}");

        $link->refresh();

        $this->assertEquals(2, $link->counter);
    }

    public function test_access_denied_if_link_expired()
    {
        // Arrange / Given
        $user = User::factory()->create();

        $link = Link::factory()->create([
            'expires_at' => now()->subDay(), // Date d'expiration dans le passé
            'shortcut_link' => 'expired1',
        ]);

        $this->actingAs($user);

        // Act / When
        $response = $this->get("/{$link->shortcut_link}");

        // Assert / Then
        $response->assertStatus(403);
        $response->assertSee('Ce lien a expiré.');
    }

    public function test_qrcode_is_displayed_and_scannable_in_dashboard()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $link = Link::factory()->create([
            'user_fk' => $user->id,
            'shortcut_link' => 'abcd123',
            'source_link' => 'https://example.com',
            'password_hash' => Hash::make('pass')
        ]);

        $response = $this->get('/dashboard');

        $response->assertStatus(200);

        // Le code QR est généralement affiché avec la balise <img> et l'attribut src pointant vers le lien
        // Ici, par exemple, nous nous attendons à ce que « abcd12 » soit dans la source de la balise img du code QR
        $response->assertSee('abcd123');
    }

}
