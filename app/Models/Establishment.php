<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Establishment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'type', // 'whiskeria', 'massage', 'motel'
        'city',
        'address',
        'latitude',
        'longitude',
        'phone',
        'cover_image',
        'gallery',
        'description',
        'is_active',
        'rating', // 0-5
        'whatsapp',
        'website',
        'banner_image',
        'schedule',
        'status',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'rating' => 'decimal:1',
        'gallery' => 'array',
        'schedule' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reviews()
    {
        return $this->hasMany(EstablishmentReview::class);
    }
}
