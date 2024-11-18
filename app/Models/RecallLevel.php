<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecallLevel extends Model
{
    use HasFactory;

    protected $fillable = [
        'level', 
        'time_to_next_level'
    ];
}
