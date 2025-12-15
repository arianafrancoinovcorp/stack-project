<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    protected $fillable = ['name', 'slug', 'settings', 'owner_id'];

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('role');
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
}

