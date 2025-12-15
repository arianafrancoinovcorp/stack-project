<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant;

class CalendarType extends Model
{
    use BelongsToTenant;
    
    protected $fillable = ['name', 'description'];
    protected $table = 'calendar_types';

    public function activities()
    {
        return $this->hasMany(Activity::class, 'type_id');
    }
}