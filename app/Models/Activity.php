<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant;

class Activity extends Model
{
    use BelongsToTenant;
    protected $fillable = [
        'date', 'time', 'duration', 'user_id', 'knowledge_id',
        'entity_id', 'type_id', 'action_id', 'description', 
        'status', 'shared'
    ];

    protected $casts = [
        'date' => 'date',
        'shared' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function entity()
    {
        return $this->belongsTo(Entity::class);
    }

    public function type()
    {
        return $this->belongsTo(CalendarType::class, 'type_id');
    }

    public function action()
    {
        return $this->belongsTo(CalendarAction::class, 'action_id');
    }

    public function knowledge()
    {
        return $this->belongsTo(CalendarKnowledge::class, 'knowledge_id');
    }
}