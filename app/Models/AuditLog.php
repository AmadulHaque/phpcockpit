<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class AuditLog extends Model
{
    use HasUuids;

    protected $guarded = [];

    protected $casts = [
        'metadata' => 'array',
    ];

    protected function user(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->metadata['user'] ?? 'System',
        );
    }

    protected function details(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->metadata['details'] ?? '',
        );
    }
}
