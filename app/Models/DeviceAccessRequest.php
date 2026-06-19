<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeviceAccessRequest extends Model
{
    protected $fillable = [
        'device_id',
        'status',
        'message',
        'decided_by',
        'decided_at',
    ];

    protected $casts = [
        'decided_at' => 'datetime',
    ];

    public function device()
    {
        return $this->belongsTo(Device::class);
    }
}
