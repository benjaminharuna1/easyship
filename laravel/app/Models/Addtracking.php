<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Addtracking extends Model
{
    protected $table = 'addtracking';
    protected $guarded = [];

    protected $casts = [
        'total_cost' => 'float',
        'total_freight' => 'float',
        'published' => 'boolean',
        'coordinates' => 'array',
    ];

    public function packageItems(): HasMany
    {
        return $this->hasMany(PackageItem::class, 'tracking_id', 'tracking_id');
    }

    public function shipmentHistory(): HasMany
    {
        return $this->hasMany(ShipmentHistory::class, 'tracking_id', 'tracking_id')
            ->orderBy('date')->orderBy('time');
    }
}
