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

    protected $table = 'qr_code';

    protected $fillable = [
        'link_id',
        'format',
        'chemin_du_fichier',
    ];

    public $timestamps = true;

   
    public function link()
    {
        return $this->belongsTo(Link::class);
    }
}
