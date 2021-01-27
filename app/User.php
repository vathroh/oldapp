<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
//use App\job_desc;
//use App\job_title;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'nik',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function roles()
    {
        return $this->belongsToMany('App\Role');
    }

    public function hasAnyRoles($roles)
    {
        if ($this->roles()->whereIn('name', $roles)->first()) {
            return true;
        }
        return false;
    }

    public function hasRole($role)
    {
        if ($this->roles()->where('name', $role)->first()) {
            return true;
        }
        return false;
    }

    // ========================================================= Job Description =================
    public function jobDesc()
    {
        return $this->hasMany('App\job_desc');
    }


    public function posisi()
    {
        return $this->hasOneThrough(
            'App\job_title',
            'App\job_desc',
            'user_id', //foreign key on job_desc 
            'id', //foreign key on job_title 
            'id', //local key on User 
            'job_title_id' // localkey on job_desc 
        );
    }

    public function areaKerja()
    {
        return $this->hasManyThrough(
            'App\work_zone',
            'App\job_desc',
            'user_id', // foreign key on job_desc 
            'id', //foreign key on work_zone 
            'id', // local key on user 
            'work_zone_id' //localkey on  job_desc 
        );
    }

    public function workZone()
    {
        return $this->hasOneThrough(
            'App\work_zone',
            'App\job_desc',
            'user_id', // foreign key on job_desc 
            'id', //foreign key on work_zone 
            'id', // local key on user 
            'work_zone_id' //localkey on  job_desc 
        );
    }

    // ============================================= Evaluasi Kinerja ====================================
    public function evaluationSetting()
    {
        return $this->hasManyThrough(
            'App\personnel_evaluation_setting',
            'App\job_desc',
            'user_id',
            'jobTitleId',
            'id',
            'job_title_id'
        );
    }

    public function evaluationValue()
    {
        return $this->hasMany('App\personnel_evaluation_value', 'userId');
    }

    // =========================================== Kegian : Rakor/KBIK/Pelatihan ==========================
    public function ActivityParticipant()
    {
        return $this->hasMany('App\activity_participant');
    }

    public function ActivityAttendances()
    {
        return $this->hasMany('App\attendance_record');
    }

    public function ActivityEvaluations()
    {
        return $this->hasMany('App\evaluation');
    }

    public function ActivityBlackList()
    {
        return $this->hasMany('App\activity_blacklist');
    }
}
