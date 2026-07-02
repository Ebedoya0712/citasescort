<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Publication extends Model
{
    protected $fillable = [
        'escort_id',
        'title',
        'description',
        'photos',
        'price',
        'city',
        'oral_sex',
        'fantasies',
        'virtual_services',
        'age',
        'gender',
        'height',
        'hair_color',
        'phone',
        'whatsapp',
        'instagram',
        'twitter',
        'onlyfans',
        'is_active',
        'attends_in',
        'attends_to',
        'schedule',
        'services',
        'currency',
        'waist',
        'hips',
        'bust',
        'telegram',
    ];

    protected $casts = [
        'photos' => 'array',
        'fantasies' => 'array',
        'virtual_services' => 'array',
        'is_active' => 'boolean',
        'price' => 'decimal:2',
        'attends_in' => 'array',
        'attends_to' => 'array',
        'services' => 'array',
    ];

    public function escort()
    {
        return $this->belongsTo(\App\Models\Escort::class);
    }
}
