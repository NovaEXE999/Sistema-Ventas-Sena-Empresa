<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'stock',
        'price',
        'status',
        'category_id',
    ];
    protected $casts = [
        'status' => 'boolean',
    ];

    // Category relation
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // SaleDetails relation
    public function saleDetails()
    {
        return $this->hasMany(SaleDetail::class);
    }

    // Product deliveries relation
    public function deliveries()
    {
        return $this->hasMany(ProductDelivery::class);
    }
}
