<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrganizationMember extends Model
{
    protected $fillable = [
        'name',
        'position',
        'contact',
        'street',
        'city',
        'parent_id',
        'sort_order',
    ];

    public function parent()
    {
        return $this->belongsTo(OrganizationMember::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(OrganizationMember::class, 'parent_id')
            ->orderBy('sort_order');
    }
}