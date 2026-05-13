<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubtaskAttachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'subtask_id',
        'file_path',
        'original_name',
        'mime_type',
        'size'
    ];

    public function task()
    {
        return $this->belongsTo(Subtask::class);
    }
}