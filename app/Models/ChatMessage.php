<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'message_type',
        'discord_user_id',
        'display_name',
        'username',
        'avatar_url',
        'avatar_emoji',
        'color_class',
        'role_key',
        'message',
        'reactions',
        'reply_name',
        'reply_text',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'reactions' => 'array',
    ];
}
