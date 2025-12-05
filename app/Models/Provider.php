<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    use HasFactory;
    protected $fillable = [
        'identification',
        'name',
        'phone_number',
        'status',
        'person_type_id',
    ];
    protected $casts = [
        'status' => 'boolean',
    ];

    public function deliveries()
    {
        return $this->hasMany(ProductDelivery::class);
    }

    public function personType()
    {
        return $this->belongsTo(PersonType::class);
    }
}
