<?php
/**
 * ETML
 * Auteur      : Mustafa Yildiz
 * Date        : 22.05.2025
 * Description : Il s'agit d'un fichier créé pour tester l'affichage des pages.
 */

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class ShowPagesFeatureTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    #[Test]
    public function homepage_displays_successfully(): void
    {
        $response = $this->get('/');  
       // Assurez-vous que HTTP 200 est renvoyé
        $response->assertStatus(200);

        // Y a-t-il un texte spécifique dans le contenu de la page ? 
        $response->assertSee('Linkeli'); 
    }

    #[Test]
    public function login_page_displays_successfully(): void
    {
        $response = $this->get('/login');  
        // Assurez-vous que HTTP 200 est renvoyé
        $response->assertStatus(200);
    }

    #[Test]
    public function register_page_displays_successfully(): void
    {
        $response = $this->get('/register');  
        // Assurez-vous que HTTP 200 est renvoyé
        $response->assertStatus(200);
    }
}
