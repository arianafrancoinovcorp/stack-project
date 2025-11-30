<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vat extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'percentage',
        'status',
    ];

    protected $casts = [
        'percentage' => 'decimal:2',
        'status' => 'string',
    ];

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function isActive()
    {
        return $this->status === 'active';
    }

    public function isInactive()
    {
        return $this->status === 'inactive';
    }
}
