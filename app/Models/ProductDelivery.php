<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDelivery extends Model
{
    use HasFactory;
    protected $fillable = [
        'date',
        'delivered_amount',
        'product_id',
        'provider_id'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }
}
