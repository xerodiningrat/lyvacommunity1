<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class LeaderboardEntry extends Model
{
    /** @use HasFactory<\Database\Factories\LeaderboardEntryFactory> */
    use HasFactory;

    protected $guarded = [];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'points' => 'int',
            'wins' => 'int',
            'events_joined' => 'int',
            'sort_order' => 'int',
            'is_active' => 'bool',
        ];
    }

    public function scopeActive(Builder $query): void
    {
        $query->where('is_active', true);
    }

    public function scopeOrdered(Builder $query): void
    {
        $query->orderByDesc('points')
            ->orderByDesc('wins')
            ->orderByDesc('events_joined')
            ->orderBy('sort_order')
            ->orderBy('player_name');
    }
}
