<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudyMethod extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'description'
    ];

    /**
     * Mối quan hệ với bảng study_sessions (một study method có nhiều study sessions)
     */
    public function studySessions()
    {
        return $this->hasMany(StudySession::class);
    }
}
