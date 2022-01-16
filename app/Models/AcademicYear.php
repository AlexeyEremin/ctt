<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicYear extends Model
{
    use HasFactory;

    public function year()
    {
        return $this->belongsTo(Year::class);
    }
    public function campus()
    {
        return $this->belongsTo(Campus::class);
    }

    public function groups()
    {
        return $this->hasMany(Group::class);
    }

    public function coulpesDates()
    {
        return $this->hasMany(CouplesDate::class);
    }
}
