<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ProjectPhoto extends Model
{
    use HasFactory;

    protected $fillable = [
        'filename',
        'original_name',
        'path',
        'comment',
        'task_id',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function getUrlAttribute()
    {
        return Storage::url($this->path);
    }

    public function getThumbnailAttribute()
    {
        return Storage::url($this->path);
    }
}
