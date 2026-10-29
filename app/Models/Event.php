<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    public const CATEGORIES = ['Technical', 'Workshop', 'Seminar', 'Cultural', 'Sports'];

    protected $fillable = [
        'title', 'category', 'starts_at', 'venue', 'organizer',
        'description', 'capacity', 'fee',
    ];

    protected function casts(): array
    {
        return [
            'starts_at' => 'datetime',
            'capacity'  => 'integer',
            'fee'       => 'integer',
        ];
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class);
    }

    public function scopeUpcoming(Builder $query): Builder
    {
        return $query->where('starts_at', '>=', now());
    }

    public function scopePast(Builder $query): Builder
    {
        return $query->where('starts_at', '<', now());
    }

    public function isPast(): bool
    {
        return $this->starts_at->isPast();
    }

    /** Uses the withCount('registrations') value when present so list pages stay at one query. */
    public function seatsTaken(): int
    {
        $counted = $this->getAttribute('registrations_count');

        return (int) ($counted ?? $this->registrations()->count());
    }

    public function seatsLeft(): int
    {
        return max(0, $this->capacity - $this->seatsTaken());
    }

    public function fillPercent(): int
    {
        if ($this->capacity < 1) {
            return 0;
        }

        return min(100, (int) round($this->seatsTaken() / $this->capacity * 100));
    }

    public function categoryClass(): string
    {
        return strtolower($this->category);
    }
}
