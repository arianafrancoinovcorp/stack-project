<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant;

class ProposalLine extends Model
{
    use HasFactory;
    use BelongsToTenant;

    protected $fillable = [
        'proposal_id',
        'item_id',
        'supplier_id',
        'quantity',
        'price',
        'cost_price',
        'subtotal',
        'notes',
    ];

    /**
     * RProposal
     */
    public function proposal()
    {
        return $this->belongsTo(Proposal::class);
    }

    /**
     * ITem
     */
    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    /**
     * (Entity)
     */
    public function supplier()
    {
        return $this->belongsTo(Entity::class, 'supplier_id');
    }


    public function getLineTotalAttribute()
    {
        return $this->price * $this->quantity;
    }
}
