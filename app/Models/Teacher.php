<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    public function teacherDisciplines()
    {
        return $this->hasMany(TeacherDiscipline::class);
    }

    public function throwGroupDisciplines()
    {
        return $this->hasManyThrough(GroupDiscipline::class, TeacherDiscipline::class);
    }
}
