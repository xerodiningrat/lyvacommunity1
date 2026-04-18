<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatPresence extends Model
{
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'discord_user_id',
        'display_name',
        'username',
        'avatar_url',
        'avatar_emoji',
        'color_class',
        'role_key',
        'last_seen_at',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'last_seen_at' => 'datetime',
    ];
}
