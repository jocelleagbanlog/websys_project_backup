<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['owner_id','name','description'];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function members()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function getCompletionPercentageAttribute()
    {
        $totalSubtasks = Subtask::whereHas('task', function ($q) {
            $q->where('project_id', $this->id);
        })->count();

        if ($totalSubtasks == 0) return 0;

        $doneSubtasks = Subtask::whereHas('task', function ($q) {
            $q->where('project_id', $this->id);
        })->where('status', 'completed')->count();

        return round(($doneSubtasks / $totalSubtasks) * 100);
    }
}
