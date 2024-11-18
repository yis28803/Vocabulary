<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vocabulary extends Model
{
    use HasFactory;

    protected $fillable = [
        'topic_id', 
        'word', 
        'type', 
        'meaning', 
        'audio_url', 
        'image_url', 
        'phonetic', 
        'example_sentence', 
        'example_translation'
    ];

    /**
     * Mối quan hệ với bảng topics (một vocabulary thuộc về một topic)
     */
    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    /**
     * Mối quan hệ với bảng study_sessions (một vocabulary có nhiều study_sessions)
     */
    public function studySessions()
    {
        return $this->hasMany(StudySession::class);
    }

    /**
     * Mối quan hệ với bảng mastered_vocabulary (một vocabulary có thể được mastered nhiều lần)
     */
    public function masteredVocabularies()
    {
        return $this->hasMany(MasteredVocabulary::class);
    }
}
