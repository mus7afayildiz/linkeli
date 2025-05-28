<?php
/**
 * ETML
 * Auteur      : Mustafa Yildiz
 * Date        : 13.05.2025
 * Description : Il s'agit du fichier modèle créé pour les informations de l'objet lien.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Link extends Model
{
    /** @use HasFactory<\Database\Factories\LinkFactory> */
    use HasFactory;

    // Le nom de la table dans la base de donnée
    protected $table = 'links';

    // La clé primaire de la table
    protected $primaryKey = 'link_id';

    // Active les colonnes created_at et updated_at
    public $timestamps = true;

    // Les colonnes qu'on peut remplir avec un formulaire
    protected $fillable = [
        'source_link',
        'shortcut_link',
        'password_protected',
        'password_hash',
        'user_fk',
        'counter',
        'expires_at'
    ];

    // Cast de la date d'expiration en type datetime
    protected $casts = [
        'expires_at' => 'datetime',
    ];

     /**
     * Relation : Un lien appartient à un utilisateur
     * 
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_fk');
    }

    /**
     * Génère automatiquement un code court unique.
     * 
     * @param int $length La longueur du code
     * @return string Le code unique
     */
    public static function generateShortcut($length = 6)
    {
        do {
            // Mélanger les caractères et couper à la longueur souhaitée
            $shortcut = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, $length);
        } while (self::where('shortcut_link', $shortcut)->exists());// Répéter si déjà utilisé

        return $shortcut;
    }

    /**
     * Relation : Un lien a un seul QR code
     * 
     * @return HasOne
     */
    public function qrCode()
    {
        return $this->hasOne(QRCode::class, 'link_id', 'link_id');
    }


    /**
     * Événement lors de la suppression d’un lien.
     * 
     * Description : Quand on supprime un lien, on supprime aussi le QR code 
     * et le fichier SVG associé du disque.
     * 
     * @return void
     */
    protected static function booted()
    {
        static::deleting(function ($link) {
            // Si un QR code est associé, le supprimer aussi
            if ($link->qrCode) {
                $qrFilePath = str_replace('storage/', '', $link->qrCode->chemin_du_fichier);
                Storage::disk('public')->delete($qrFilePath); // Supprimer fichier
                $link->qrCode->delete();// Supprimer base de données
            }
        });
    }
    

}
