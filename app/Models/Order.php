<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'number',
        'order_date',
        'valid_until',
        'client_id',
        'status'
    ];

    public function client()
    {
        return $this->belongsTo(Entity::class, 'client_id');
    }

    public function lines()
    {
        return $this->hasMany(OrderLine::class);
    }

    public function getTotalAttribute()
    {
        return $this->lines->sum(fn($l) => $l->quantity * $l->price);
    }
}
