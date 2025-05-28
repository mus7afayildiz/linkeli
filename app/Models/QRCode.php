<?php
/**
 * ETML
 * Auteur      : Mustafa Yildiz
 * Date        : 13.05.2025
 * Description : Il s'agit du fichier modèle créé pour les informations de l'objet QRCode.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QRCode extends Model
{
    use HasFactory;

    // Le nom de la table dans la base de données
    protected $table = 'qr_code';

    // Les champs qu'on peut remplir avec un formulaire
    protected $fillable = [
        'link_id',
        'format',
        'chemin_du_fichier',
    ];

    // Active les colonnes created_at et updated_at
    public $timestamps = true;

   /**
     * Relation : Un QRCode appartient à un lien.
     * 
     * @return BelongsTo
     */
    public function link()
    {
        return $this->belongsTo(Link::class);
    }
}
