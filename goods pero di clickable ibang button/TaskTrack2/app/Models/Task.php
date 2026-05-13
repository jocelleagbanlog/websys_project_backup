<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['project_id','title','description','status','completed_at'];

    protected $casts = [
        'completed_at' => 'datetime',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function subtasks()
    {
        return $this->hasMany(Subtask::class);
    }

    public function getCompletionPercentageAttribute()
    {
        $total = $this->subtasks()->count();
        if ($total == 0) return 0;

        $done = $this->subtasks()->where('status', 'completed')->count();
        return round(($done / $total) * 100);
    }

    protected static function booted()
    {
        static::saving(function ($task) {
            if ($task->isDirty('status') && $task->status === 'completed') {
                $task->completed_at = now();
            }
        });
    }
}
