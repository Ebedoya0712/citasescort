<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Escort;

class Story extends Model
{
    use HasFactory;

    protected $fillable = [
        'escort_id',
        'media_path',
        'media_type',
        'caption',
        'is_active',
        'expires_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'expires_at' => 'datetime',
        'media_path' => 'array',
    ];

    protected static function booted(): void
    {
        static::addGlobalScope('active_expiration', function (Builder $builder) {
            $builder->where('expires_at', '>', now());
        });

        static::creating(function (Story $story) {
            if (empty($story->expires_at)) {
                $story->expires_at = now()->addHours(24);
            }
        });

        static::saving(function (Story $story) {
            $paths = $story->media_path;
            
            if (empty($paths)) {
                return;
            }

            // Handle both array and string (legacy)
            $firstPath = is_array($paths) ? ($paths[0] ?? null) : $paths;

            if ($firstPath) {
                $extension = pathinfo($firstPath, PATHINFO_EXTENSION);
                $story->media_type = in_array(strtolower($extension), ['mp4', 'mov', 'avi', 'webm']) ? 'video' : 'image';
            }
        });
    }

    public function escort(): BelongsTo
    {
        return $this->belongsTo(Escort::class);
    }
}
