<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkerPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'worker_id',
        'date',
        'amount',
        'observation',
        'user_id',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'date' => 'date',
    ];

    public function worker()
    {
        return $this->belongsTo(Worker::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
