<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstablishmentReview extends Model
{
    protected $fillable = [
        'establishment_id',
        'user_id',
        'name',
        'rating',
        'content',
        'private_content',
        'is_public',
    ];

    public function establishment()
    {
        return $this->belongsTo(Establishment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
