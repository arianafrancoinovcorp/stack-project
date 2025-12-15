<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant;

class CalendarKnowledge extends Model
{
    use BelongsToTenant;
    
    protected $table = 'calendar_knowledges';
    
    protected $fillable = ['name', 'description'];

    public function activities()
    {
        return $this->hasMany(Activity::class, 'knowledge_id');
    }
}