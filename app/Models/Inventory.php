<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inventory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'business_id',
        'product_id',
        'warehouse_id',
        'quantity',
        'reorder_level',
        'reorder_quantity',
        'unit_cost',
        'location',
        'status',
        'last_updated',
        'notes'
    ];

    protected $casts = [
        'quantity' => 'integer',
        'reorder_level' => 'integer',
        'reorder_quantity' => 'integer',
        'unit_cost' => 'decimal:2',
        'last_updated' => 'datetime',
    ];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function movements()
    {
        return $this->hasMany(InventoryMovement::class);
    }

    public function getStockValueAttribute()
    {
        return $this->quantity * ($this->unit_cost ?? $this->product->price ?? 0);
    }

    public function getStockStatusAttribute()
    {
        if ($this->quantity <= 0) {
            return 'out_of_stock';
        } elseif ($this->quantity <= $this->reorder_level) {
            return 'low_stock';
        } else {
            return 'in_stock';
        }
    }

    public function scopeLowStock($query)
    {
        return $query->where('quantity', '<=', 'reorder_level');
    }

    public function scopeOutOfStock($query)
    {
        return $query->where('quantity', '<=', 0);
    }

    public function scopeInStock($query)
    {
        return $query->where('quantity', '>', 'reorder_level');
    }
} 