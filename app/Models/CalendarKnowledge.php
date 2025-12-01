<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CalendarKnowledge extends Model
{
    protected $table = 'calendar_knowledges';
    
    protected $fillable = ['name', 'description'];

    public function activities()
    {
        return $this->hasMany(Activity::class, 'knowledge_id');
    }
}