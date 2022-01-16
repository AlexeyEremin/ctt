<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HorlyLoad extends Model
{
    use HasFactory;

    public function lessonType()
    {
        return $this->belongsTo(LessonType::class);
    }

    public function countPairs()
    {
        return $this->hasMany(Schedule::class)->count();
    }
}
