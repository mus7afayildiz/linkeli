<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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


    public static function generateShortcut($length = 6)
    {
        do {
            $shortcut = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, $length);
        } while (self::where('shortcut_link', $shortcut)->exists());

        return $shortcut;
    }
}
