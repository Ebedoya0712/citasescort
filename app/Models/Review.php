<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'escort_id',
        'user_id',
        'name',
        'rating',
        'content',
        'private_content',
        'is_public',
    ];

    public function escort()
    {
        return $this->belongsTo(Escort::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
