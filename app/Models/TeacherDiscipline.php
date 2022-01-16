<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherDiscipline extends Model
{
    use HasFactory;
    protected $fillable = ['teacher_id', 'discipline_id'];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
    public function discipline()
    {
        return $this->belongsTo(Discipline::class);
    }

    public function groupDisciplines()
    {
        return $this->hasMany(GroupDiscipline::class);
    }
}
