<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id', 
        'name'
    ];

    /**
     * Mối quan hệ với bảng courses (một topic thuộc về một course)
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Mối quan hệ với bảng vocabularies (một topic có nhiều vocabularies)
     */
    public function vocabularies()
    {
        return $this->hasMany(Vocabulary::class);
    }
}
