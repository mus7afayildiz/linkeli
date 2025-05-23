<?php

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
