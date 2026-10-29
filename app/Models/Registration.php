<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Registration extends Model
{
    public const CLASS_OPTIONS = [
        'IT25 A (Batch A)',
        'IT25 A (Batch B)',
        'IT25 B (Batch A)',
        'IT25 B (Batch B)',
    ];

    protected $fillable = ['event_id', 'name', 'email', 'enrollment', 'phone', 'class_name'];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function refCode(): string
    {
        return 'REG-' . $this->created_at->format('Y') . '-' . str_pad((string) $this->id, 4, '0', STR_PAD_LEFT);
    }
}
