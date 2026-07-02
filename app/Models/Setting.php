<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'key',
        'label',
        'value',
        'type',
        'group',
    ];

    protected $casts = [
        'value' => 'json', // Cast to JSON if needed, or string. For mixed types, accessors might be better, but 'string' is safest for now unless we use 'array' cast. Let's stick to default string/text handling in controller for flexibility, or maybe simple string.
        // Actually, for file uploads, we store path string. For text, string. For boolean, "1"/"0".
    ];
}
