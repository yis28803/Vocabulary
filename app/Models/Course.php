<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'description'
    ];

    /**
     * Mối quan hệ với bảng topics (một course có nhiều topics)
     */
    public function topics()
    {
        return $this->hasMany(Topic::class);
    }
}
