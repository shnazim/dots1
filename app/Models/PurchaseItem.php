<?php

namespace App\Models;

use App\Traits\MultiTenant;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class PurchaseItem extends Model {
    use MultiTenant;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'purchase_items';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'purchase_id', 'product_id', 'product_name', 'description', 'quantity', 'unit_cost', 'sub_total',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id')->withDefault();
    }

    public function taxes() {
        return $this->hasMany(PurchaseItemTax::class, 'purchase_item_id');
    }

    protected function unitCost(): Attribute {
        $decimal_place = get_business_option('decimal_places', 2);

        return Attribute::make(
            get:fn(string $value) => number_format($value, $decimal_place, '.', ''),
        );
    }

    protected function subTotal(): Attribute {
        $decimal_place = get_business_option('decimal_places', 2);

        return Attribute::make(
            get:fn(string $value) => number_format($value, $decimal_place, '.', ''),
        );
    }

}