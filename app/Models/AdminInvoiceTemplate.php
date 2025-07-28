<?php

namespace App\Models;

use App\Traits\MultiTenant;
use Illuminate\Database\Eloquent\Model;

class AdminInvoiceTemplate extends Model {
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'admin_invoice_templates';
}