<?php

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
       // Kullanıcı oluşturulup oturum açılıyor
       $user = User::factory()->create();
       $this->actingAs($user);

       // POST isteği yapılıyor
       $response = $this->post('/links/store', [
           'lienDeSource' => 'https://example.com',
       ]);

       // Response başarılı mı?
       $response->assertRedirect('/dashboard');

       // DB kontrolü yapılıyor
       $this->assertDatabaseHas('links', [
           'source_link' => 'https://example.com',
       ]);
    }
}
