<?php
/**
 * ETML
 * Auteur      : Mustafa Yildiz
 * Date        : 13.05.2025
 * Description : 
 */

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\Notification;
use App\Models\User;

class EmailForVerificationFeatureTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function user_receives_verification_email_upon_registration(): void
    {
        Notification::fake();

        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        // Après l'inscription, l'utilisateur devrait recevoir une notification de vérification
        $user = User::where('email', 'test@example.com')->first();
        Notification::assertSentTo($user, VerifyEmail::class);

        // Vous devriez être dirigé vers l'écran d'attente de vérification
        $response->assertRedirect('/dashboard');
    }
}
