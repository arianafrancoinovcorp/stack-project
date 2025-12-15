<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant;

class ContactFunction extends Model
{
    use HasFactory;
    use BelongsToTenant;

    protected $fillable = ['name'];

    public function contacts()
    {
        return $this->hasMany(Contact::class, 'function_id');
    }
}
