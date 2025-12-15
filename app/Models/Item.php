<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant;

class Item extends Model {
    use HasFactory;
    use BelongsToTenant;

    protected $table = 'items';

    protected $fillable = [
        'reference', 'name', 'description', 'price', 'vat_id', 'photo', 'notes', 'status'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'status' => 'string',
    ];

    public function vat() {
        return $this->belongsTo(Vat::class);
    }

    public function isActive() {
        return $this->status === 'active';
    }

    public function isInactive() {
        return $this->status === 'inactive';
    }
}
