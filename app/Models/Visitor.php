<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'name',
        'whatsapp_number',
        'first_visit_at',
        'last_visit_at',
        'total_visits',
        'whatsapp_clicks',
        'utm_source',
        'utm_medium',
        'utm_campaign',
        'utm_content',
        'utm_term',
        'gclid',
        'fbclid',
        'ip_address',
        'user_agent',
        'browser',
        'device',
        'city',
        'country'
    ];

    protected $casts = [
        'first_visit_at' => 'datetime',
        'last_visit_at' => 'datetime',
        'total_visits' => 'integer',
        'whatsapp_clicks' => 'integer',
    ];

    /**
     * Relación con los logs de visitas.
     */
    public function logs()
    {
        return $this->hasMany(VisitLog::class);
    }
}
