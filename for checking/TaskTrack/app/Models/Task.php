<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'user_id','title','description','category_id','status','priority'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function subtasks()
{
    return $this->hasMany(Subtask::class);
}
}
