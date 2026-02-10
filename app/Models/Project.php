<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Project extends Model
{
    use HasUuids;

    protected $guarded = [];

    protected $casts = [
        'is_favorite' => 'boolean',
    ];

    public function gitState(): HasOne
    {
        return $this->hasOne(GitState::class);
    }

    public function phpVersion(): BelongsTo
    {
        return $this->belongsTo(RuntimeVersion::class, 'php_version_id');
    }

    public function nodeVersion(): BelongsTo
    {
        return $this->belongsTo(RuntimeVersion::class, 'node_version_id');
    }

    public function savedCommands(): HasMany
    {
        return $this->hasMany(SavedCommand::class);
    }

    public function auditLogs(): HasMany
    {
        return $this->hasMany(AuditLog::class)->latest();
    }

    public function notes(): HasMany
    {
        return $this->hasMany(Note::class);
    }

    // Helper to get the single scratchpad note
    public function scratchpad(): HasOne
    {
        return $this->hasOne(Note::class)->latestOfMany();
    }
}
