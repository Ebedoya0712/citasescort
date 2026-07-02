<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'visitor_id',
        'url',
        'referrer',
        'duration'
    ];

    protected $casts = [
        'duration' => 'integer',
    ];

    /**
     * Relación con el visitante.
     */
    public function visitor()
    {
        return $this->belongsTo(Visitor::class);
    }
}
