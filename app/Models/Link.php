<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Link extends Model
{
    /** @use HasFactory<\Database\Factories\LinkFactory> */
    use HasFactory;

    protected $table = 'links';
    protected $primaryKey = 'link_id';
    public $timestamps = true;

    protected $fillable = [
        'source_link',
        'shortcut_link',
        'password_protected',
        'password_hash',
        'user_fk',
        'counter',
        'expires_at'
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_fk');
    }

    /**
     * autogen with random unless...
     */
    public static function generateShortcut($length = 6)
    {
        do {
            $shortcut = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, $length);
        } while (self::where('shortcut_link', $shortcut)->exists());

        return $shortcut;
    }

    public function qrCode()
    {
        return $this->hasOne(QRCode::class, 'link_id', 'link_id');
    }


    protected static function booted()
    {
        static::deleting(function ($link) {
            if ($link->qrCode) {
                $qrFilePath = str_replace('storage/', '', $link->qrCode->chemin_du_fichier);
                Storage::disk('public')->delete($qrFilePath);
                $link->qrCode->delete();
            }
        });
    }
    

}
