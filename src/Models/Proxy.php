<?php

namespace Mrethical\HttpProxies\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $ip
 * @property int $port
 * @property bool $is_active
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

    public function getIpPortAttribute(): string
    {
        return $this->ip.':'.$this->port;
    }
}
