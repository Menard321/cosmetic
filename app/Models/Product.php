<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'name', 'brand', 'price', 'description', 'image_url', 'is_trending', 'stock_quantity', 'is_active'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function branches()
    {
        return $this->belongsToMany(Branch::class, 'branch_inventories')
                    ->withPivot('stock_quantity', 'price_override', 'is_available')
                    ->withTimestamps();
    }

    public function getStockForBranch($branchId)
    {
        $branchInfo = $this->branches()->where('branch_id', $branchId)->first();
        return $branchInfo ? $branchInfo->pivot->stock_quantity : 0;
    }

    public function getPriceForBranch($branchId)
    {
        $branchInfo = $this->branches()->where('branch_id', $branchId)->first();
        return ($branchInfo && $branchInfo->pivot->price_override) ? $branchInfo->pivot->price_override : $this->price;
    }

    public function batches()
    {
        return $this->hasMany(InventoryBatch::class);
    }

    public function inventoryLogs()
    {
        return $this->hasMany(InventoryLog::class);
    }
}
