<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subtask extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_id',
        'title',
        'description',
        'status',
        'completed_at',
        'assigned_to'
    ];

    protected $casts = [
        'completed_at' => 'datetime',
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function assignee()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function attachments()
    {
        return $this->hasMany(SubtaskAttachment::class);
    }

    protected static function booted()
    {
        static::saving(function ($subtask) {

            if ($subtask->status === 'completed' && !$subtask->completed_at) {
                $subtask->completed_at = now();
            }

            if ($subtask->status !== 'completed') {
                $subtask->completed_at = null;
            }
        });
    }
}