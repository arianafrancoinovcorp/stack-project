<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entity extends Model
{
    use HasFactory;

    protected $fillable = [
        'nif',
        'name',
        'address',
        'zip_code',
        'city',
        'country_id',
        'phone',
        'mobile',
        'website',
        'email',
        'rgpd_consent',
        'notes',
        'status',
    ];

    protected $casts = [
        'rgpd_consent' => 'boolean',
        'status' => 'string',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function types()
    {
        return $this->belongsToMany(Type::class)->withTimestamps();
    }
}
