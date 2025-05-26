<?php
/**
 * ETML
 * Auteur      : Mustafa Yildiz
 * Date        : 13.05.2025
 * Description : C'est un fichier créé pour générer automatiquement des liens.
 */

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Link>
 */
class LinkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'source_link' => 'https://example.com',
            'shortcut_link' => Str::random(6), 
            'password_protected' => false,
            'password_hash' => null,
            'user_fk' => \App\Models\User::factory(),
            'counter' => 0,
            'expires_at' => now()->addMonth(),
        ];
    }
}
