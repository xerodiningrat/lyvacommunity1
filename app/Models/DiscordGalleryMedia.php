<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiscordGalleryMedia extends Model
{
    protected $guarded = [];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'posted_at' => 'datetime',
        ];
    }
}
