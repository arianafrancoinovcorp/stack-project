<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CalendarAction extends Model
{
    protected $fillable = ['name', 'description'];
    protected $table = 'calendar_actions';

    public function activities()
    {
        return $this->hasMany(Activity::class, 'action_id');
    }
}