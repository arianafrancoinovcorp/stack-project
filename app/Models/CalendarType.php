<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CalendarType extends Model
{
    protected $fillable = ['name', 'description'];
    protected $table = 'calendar_types';

    public function activities()
    {
        return $this->hasMany(Activity::class, 'type_id');
    }
}