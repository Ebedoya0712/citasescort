<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Escort extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'profile_photo',
        'description',
        'age',
        'gender',
        'city',
        'reviews_count',
        'reviews_avg_stars',
        'price',
        'is_active',
        'user_id',
        'verified',
        'level',
        'plan_id',
        'plan_expires_at',
        'photos',
        'verification_photos',
        'phone',
        'whatsapp',
        'height',
        'hair_color',
        'cost_30m',
        'services',
        'attends_to',
        'attends_in',
        'schedule',
        'video',
        'category',
        'oral_sex',
        'fantasies',
        'virtual_services',
        'instagram',
        'onlyfans',
        'twitter',
        'currency',
        'id_front',
        'id_back',
        'verification_video',
        'verification_status',
        'waist',
        'hips',
        'bust',
        'telegram',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'verified' => 'boolean',
        'price' => 'decimal:2',
        'plan_expires_at' => 'datetime',
        'photos' => 'array',
        'verification_photos' => 'array',
        'services' => 'array',
        'attends_to' => 'array',
        'attends_in' => 'array',
        'schedule' => 'array',
        'fantasies' => 'array',
        'virtual_services' => 'array',
    ];

    protected static function booted()
    {
        static::saving(function ($model) {
            if ($model->isDirty('verified') && $model->verified) {
                $model->is_active = true;
            }
        });
    }

    public function isVerified(): bool
    {
        return $this->verified || $this->verification_status === 'approved';
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function stories()
    {
        return $this->hasMany(Story::class);
    }

    public function publications()
    {
        return $this->hasMany(Publication::class);
    }

    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites', 'escort_id', 'user_id')->withTimestamps();
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }

    /**
     * Check if the escort has an active (non-expired) plan.
     */
    public function hasActivePlan(): bool
    {
        return $this->plan_id && $this->plan_expires_at && $this->plan_expires_at->isFuture();
    }
}
