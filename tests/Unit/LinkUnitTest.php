<?php
/**
 * ETML
 * Auteur      : Mustafa Yildiz
 * Date        : 13.05.2025
 * Description : 
 */

namespace Tests\Unit;

//use PHPUnit\Framework\TestCase;
use App\Models\Link;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

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
}
