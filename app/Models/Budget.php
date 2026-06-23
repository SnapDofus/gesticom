<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    use HasFactory;

    protected $fillable = [
        'category',
        'planned_amount',
        'spent_amount',
        'user_id',
    ];

    protected $casts = [
        'planned_amount' => 'decimal:2',
        'spent_amount' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getRemainingAttribute()
    {
        return max(0, $this->planned_amount - $this->spent_amount);
    }

    public function getProgressPercentageAttribute()
    {
        if ($this->planned_amount <= 0) return 0;
        return min(100, round(($this->spent_amount / $this->planned_amount) * 100));
    }

    public function getIsOverBudgetAttribute()
    {
        return $this->spent_amount > $this->planned_amount;
    }
}
