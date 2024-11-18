<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudySession extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'vocabulary_id', 
        'study_method_id', 
        'level', 
        'last_studied_at', 
        'next_review_at',
        'question'
    ];

    protected $casts = [
        'next_review_at' => 'datetime',
    ];

    /**
     * Mối quan hệ với bảng users (một study session thuộc về một user)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Mối quan hệ với bảng vocabularies (một study session có một vocabulary)
     */
    public function vocabulary()
    {
        return $this->belongsTo(Vocabulary::class);
    }

    /**
     * Mối quan hệ với bảng study_methods (một study session có một study method)
     */
    public function studyMethod()
    {
        return $this->belongsTo(StudyMethod::class);
    }

    /**
     * Mối quan hệ với bảng review_history (một study session có nhiều review_history)
     */
    public function reviewHistory()
    {
        return $this->hasMany(ReviewHistory::class);
    }
}
