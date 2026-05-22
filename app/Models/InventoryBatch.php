<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryBatch extends Model
{
    protected $fillable = [
        'product_id', 'supplier_id', 'batch_number', 'expiry_date', 
        'initial_quantity', 'current_quantity', 'received_at'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
