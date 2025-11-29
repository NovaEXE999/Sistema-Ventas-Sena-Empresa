<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'second_last_name'
    ];

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    // Nombre completo concatenando las partes disponibles
    public function getFullNameAttribute(): string
    {
        return trim(collect([
            $this->first_name,
            $this->middle_name,
            $this->last_name,
            $this->second_last_name,
        ])->filter()->join(' '));
    }
}
