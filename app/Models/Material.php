<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Material extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'unit',
        'quantity_planned',
        'quantity_purchased',
        'estimated_price',
        'actual_price',
        'supplier',
        'purchase_date',
        'status',
        'observation',
        'user_id',
    ];

    protected $casts = [
        'quantity_planned' => 'decimal:2',
        'quantity_purchased' => 'decimal:2',
        'estimated_price' => 'decimal:2',
        'actual_price' => 'decimal:2',
        'purchase_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getRemainingQuantityAttribute()
    {
        return max(0, $this->quantity_planned - $this->quantity_purchased);
    }

    public function getTotalActualCostAttribute()
    {
        return $this->actual_price ?? 0;
    }

    public function getTotalEstimatedCostAttribute()
    {
        return $this->estimated_price;
    }
}
