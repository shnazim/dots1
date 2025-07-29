<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Warehouse extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'business_id',
        'name',
        'code',
        'address',
        'city',
        'state',
        'country',
        'postal_code',
        'phone',
        'email',
        'manager_name',
        'capacity',
        'capacity_unit',
        'status',
        'notes'
    ];

    protected $casts = [
        'capacity' => 'decimal:2',
    ];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function inventory()
    {
        return $this->hasMany(Inventory::class);
    }

    public function shipments()
    {
        return $this->hasMany(Shipment::class, 'origin_warehouse_id');
    }

    public function receivedShipments()
    {
        return $this->hasMany(Shipment::class, 'destination_warehouse_id');
    }

    public function getUtilizationPercentageAttribute()
    {
        if ($this->capacity <= 0) {
            return 0;
        }

        $totalItems = $this->inventory()->sum('quantity');
        return min(100, ($totalItems / $this->capacity) * 100);
    }

    public function getTotalInventoryValueAttribute()
    {
        return $this->inventory()
            ->join('products', 'inventory.product_id', '=', 'products.id')
            ->selectRaw('SUM(inventory.quantity * products.price) as total_value')
            ->value('total_value') ?? 0;
    }

    public function getTotalItemsAttribute()
    {
        return $this->inventory()->sum('quantity');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeByLocation($query, $country = null, $state = null, $city = null)
    {
        if ($country) {
            $query->where('country', $country);
        }
        if ($state) {
            $query->where('state', $state);
        }
        if ($city) {
            $query->where('city', $city);
        }
        return $query;
    }
} 