<?php

namespace Mrethical\HttpProxies\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $ip
 * @property int $port
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Proxy extends Model
{
    use HasFactory;

    protected $fillable = [
        'ip',
        'port',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function scopeIsActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeIsInactive($query)
    {
        return $query->where('is_active', false);
    }

    public function getIpPortAttribute(): string
    {
        return $this->ip.':'.$this->port;
    }
}
