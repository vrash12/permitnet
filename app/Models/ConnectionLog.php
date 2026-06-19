<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConnectionLog extends Model
{
    protected $fillable = [
        'device_id',
        'mac_address',
        'ip_address',
        'hostname',
        'event_type',
        'action',
        'status',
        'message',
    ];

    public function device()
    {
        return $this->belongsTo(Device::class);
    }
}
