<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupDiscipline extends Model
{
    use HasFactory;

    public function teacherDiscipline()
    {
        return $this->belongsTo(TeacherDiscipline::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function hourlyLoad()
    {
        return $this->hasMany(HorlyLoad::class);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
}
