<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'entity_id', 'first_name', 'last_name', 'function_id', 
        'phone', 'mobile', 'email', 'rgpd_consent', 'notes', 'status'
    ];

    protected $casts = [
        'rgpd_consent' => 'boolean',
        'status' => 'string',
    ];

    public function entity()
    {
        return $this->belongsTo(Entity::class);
    }

    public function function()
    {
        return $this->belongsTo(ContactFunction::class, 'function_id');
    }
}
