<?php
/**
 * ETML
 * Auteur      : Mustafa Yildiz
 * Date        : 22.05.2025
 * Description : 
 */

namespace Tests\Unit;

use App\Models\Link;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LinkUnitTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     */
    public function test_example(): void
    {
        $this->assertTrue(true);
    }

    public function test_auto_generates_shortcut_if_empty()
    {
        $link = Link::factory()->make([ 'shortcut_link' => '',]);
        $link->save();

        $this->assertNotNull($link->shortcut_link);
    }

    public function test_shortcut_must_be_unique()
    {
        $this->expectException(\Illuminate\Database\QueryException::class);

        // Créer le premier lien
        Link::factory()->create([
            'shortcut_link' => 'abc123',
        ]);

       // Si un deuxième lien est tenté d'être créé avec le même raccourci, il devrait générer une exception.
        Link::factory()->create([
            'shortcut_link' => 'abc123',
        ]);
    }


    public function test_access_denied_with_wrong_password()
    {
        $this->withSession([]);

        // Création d’un lien protégé
        $link = Link::factory()->create([
            'source_link' => 'https://example.com',
            'shortcut_link' => 'abc123',
            'password_protected' => 1,
            'password_hash' => Hash::make('bonmotdepasse'),
        ]);

        // L’utilisateur soumet un mauvais mot de passe
        $response = $this->post("/verifier-motdepasse/{$link->shortcut_link}", [
            'password' => 'mauvaismots'
        ]);

        // L’accès est refusé et message d’erreur affiché
        $response->assertRedirect(); // vers la même page avec erreur
        $response->assertSessionHasErrors(['password']);

        // Pour vérifier le message, on peut aussi ajouter :
        $this->assertTrue(session()->hasOldInput('password'));
    }


    public function test_redirection_fonctionne_avec_un_lien_non_protege()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        // On crée un lien sans mot de passe
        $link = Link::create([
            'source_link' => 'https://example.com',
            'shortcut_link' => 'test123',
            'password_protected' => 0,
            //'password_hash' => null,
            'user_fk' => $user->id,
            'counter' => 0,
            'expires_at' => now()->addDays(30),
        ]);

        // On accède à l'URL raccourcie
        $response = $this->get('/' . $link->shortcut_link);

        // On est redirigé vers le lien source
        $response->assertRedirect($link->source_link);
    }

    public function test_le_compteur_augmente_apres_redirection()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        // Création d'un lien non protégé avec un compteur à 0
        $link = Link::create([
            'source_link' => 'https://example.com',
            'shortcut_link' => 'testclick',
            'password_protected' => false,
            'user_fk' => $user->id,
            'counter' => 0,
            'expires_at' => now()->addDays(30),
        ]);

        // On accède au lien raccourci
        $this->get('/' . $link->shortcut_link);

        // Le compteur doit être à 1
        $link->refresh(); // Recharge les données depuis la BDD
        $this->assertEquals(1, $link->counter);
    }

    public function test_lien_expire_retourne_403()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        // Création d’un lien avec une date d’expiration passée
        $link = Link::create([
            'source_link' => 'https://example.com',
            'shortcut_link' => 'expirelink',
            'password_protected' => false,
            'user_fk' => $user->id,
            'counter' => 0,
            'expires_at' => now()->subDay(), // Déjà expiré
        ]);

        // Tentative d’accès au lien
        $response = $this->get('/' . $link->shortcut_link);

        // Doit retourner 403 Forbidden
        $response->assertStatus(403);
    }


}
