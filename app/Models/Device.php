<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $fillable = [
        'mac_address',
        'ip_address',
        'hostname',
        'owner_name',
        'status',
        'role',
        'last_seen_at',
    ];

    protected $casts = [
        'last_seen_at' => 'datetime',
    ];

    public function accessRequests()
    {
        return $this->hasMany(DeviceAccessRequest::class);
    }

    public function logs()
    {
        return $this->hasMany(ConnectionLog::class);
    }
}
