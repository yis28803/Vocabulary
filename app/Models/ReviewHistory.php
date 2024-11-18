<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'study_session_id', 
        'reviewed_at', 
        'result'
    ];

    /**
     * Mối quan hệ với bảng study_sessions (một review history thuộc về một study session)
     */
    public function studySession()
    {
        return $this->belongsTo(StudySession::class);
    }
}
