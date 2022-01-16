<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'login',
        'password',
        'api_token'
    ];

    protected $hidden = [
        'password',
        'api_token',
        'created_at',
        'updated_at'
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function campus()
    {
        return $this->belongsTo(Campus::class);
    }

    /**
     * @param $role
     * @return bool
     */
    public function access($role)
    {
        return ($this->role == $role);
    }

    public function teachers()
    {
        return $this->hasMany(Teacher::class, 'organization_id', 'organization_id');
    }
    public function disciplines()
    {
        return $this->hasMany(Discipline::class, 'organization_id', 'organization_id');
    }
    public function campuses()
    {
        return $this->hasMany(Campus::class, 'organization_id', 'organization_id');
    }
    public function accounts()
    {
        return $this->hasMany(self::class, 'organization_id', 'organization_id');
    }
    public function lessonTypes()
    {
        return $this->hasMany(LessonType::class, 'organization_id', 'organization_id');
    }
    public function years()
    {
        return $this->hasMany(Year::class, 'organization_id', 'organization_id');
    }
}
