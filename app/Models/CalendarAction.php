<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant;

class CalendarAction extends Model
{

    use BelongsToTenant;

    protected $fillable = ['name', 'description'];
    protected $table = 'calendar_actions';

    public function activities()
    {
        return $this->hasMany(Activity::class, 'action_id');
    }
}