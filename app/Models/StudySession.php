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
        'level', 
        'last_studied_at', 
        'next_review_at',
        'question',
        'completed_methods',
        'hints',
    ];

    protected $casts = [
        'next_review_at' => 'datetime',
        'options' => 'array',
        'completed_methods' => 'array',
        'hints' => 'array',
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
     * Mối quan hệ với bảng review_history (một study session có nhiều review_history)
     */
    public function reviewHistory()
    {
        return $this->hasMany(ReviewHistory::class);
    }
}
