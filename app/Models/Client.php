<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    protected $fillable = [
        'identification',
        'name',
        'phone_number',
        'status',
        'client_type_id',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public function clientType()
    {
        return $this->belongsTo(ClientType::class);
    }
}
