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
}
