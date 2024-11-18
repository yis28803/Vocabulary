<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasteredVocabulary extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'vocabulary_id', 
        'mastered_at'
    ];

    /**
     * Mối quan hệ với bảng users (một mastered vocabulary thuộc về một user)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Mối quan hệ với bảng vocabularies (một mastered vocabulary thuộc về một vocabulary)
     */
    public function vocabulary()
    {
        return $this->belongsTo(Vocabulary::class);
    }
}
