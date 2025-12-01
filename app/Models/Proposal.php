<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proposal extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'proposal_date',
        'client_id',
        'valid_until',
        'status',
        'total',
        'notes',
    ];

    /**
     * (Entity)
     */
    public function client()
    {
        return $this->belongsTo(Entity::class, 'client_id');
    }

    
    public function lines()
    {
        return $this->hasMany(ProposalLine::class);
    }

   
    public function getTotalAttribute()
    {
        return $this->lines->sum(fn($line) => $line->price * $line->quantity);
    }
}
