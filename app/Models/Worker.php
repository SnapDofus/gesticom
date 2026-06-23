<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Worker extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'full_name',
        'phone',
        'function',
        'daily_wage',
        'user_id',
    ];

    protected $casts = [
        'daily_wage' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payments()
    {
        return $this->hasMany(WorkerPayment::class);
    }

    public function getTotalPaidAttribute()
    {
        return $this->payments()->sum('amount');
    }
}
