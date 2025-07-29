<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shipment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'business_id',
        'order_id',
        'tracking_number',
        'carrier_id',
        'origin_warehouse_id',
        'destination_warehouse_id',
        'shipping_address',
        'billing_address',
        'shipping_method',
        'shipping_cost',
        'weight',
        'dimensions',
        'status',
        'shipped_at',
        'delivered_at',
        'estimated_delivery',
        'actual_delivery',
        'notes',
        'tracking_events'
    ];

    protected $casts = [
        'shipping_cost' => 'decimal:2',
        'weight' => 'decimal:2',
        'dimensions' => 'array',
        'shipped_at' => 'datetime',
        'delivered_at' => 'datetime',
        'estimated_delivery' => 'datetime',
        'actual_delivery' => 'datetime',
        'tracking_events' => 'array',
    ];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function carrier()
    {
        return $this->belongsTo(Carrier::class);
    }

    public function originWarehouse()
    {
        return $this->belongsTo(Warehouse::class, 'origin_warehouse_id');
    }

    public function destinationWarehouse()
    {
        return $this->belongsTo(Warehouse::class, 'destination_warehouse_id');
    }

    public function items()
    {
        return $this->hasMany(ShipmentItem::class);
    }

    public function trackingHistory()
    {
        return $this->hasMany(ShipmentTracking::class);
    }

    public function getDeliveryDaysAttribute()
    {
        if ($this->shipped_at && $this->delivered_at) {
            return $this->shipped_at->diffInDays($this->delivered_at);
        }
        return null;
    }

    public function getIsDelayedAttribute()
    {
        if ($this->estimated_delivery && !$this->delivered_at) {
            return now()->isAfter($this->estimated_delivery);
        }
        return false;
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'pending' => 'warning',
            'shipped' => 'info',
            'in_transit' => 'primary',
            'out_for_delivery' => 'info',
            'delivered' => 'success',
            'failed' => 'danger',
            'returned' => 'secondary',
            default => 'secondary'
        };
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeDelayed($query)
    {
        return $query->where('estimated_delivery', '<', now())
                    ->whereNull('delivered_at');
    }

    public function scopeDelivered($query)
    {
        return $query->whereNotNull('delivered_at');
    }

    public function scopeInTransit($query)
    {
        return $query->whereIn('status', ['shipped', 'in_transit', 'out_for_delivery']);
    }
} 