<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Providers;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $guard_name = 'api';

    protected $fillable = [       
        'email',
        'password','email_verified_at','remember_token',
        'phone','verification_code','code'
        ,'status_subscription','push_token','role_id'
    ];

    //protected $with = ['providers'];


    protected $hidden = [
        'password',
        'remember_token', 'pivot', 'verification_code','code'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function providers()
    {
        return $this->hasMany(Providers::class,'user_id','id');
    }

    public function workingDaysSync()//для crud
    {
        return $this->belongsToMany(UserWorkingDay::class,'user_working_days','user_id','id');
    }

    public function workingDays()
    {
        return $this->hasMany(UserWorkingDay::class,'user_id','id');
    }

    public function licenses()
    {
        return $this->hasMany(UserLicense::class,'user_id','id');
    }

    public function infoCompany()
    {
        return $this->hasOne(InfoCompany::class,'user_id','id');
    }

    public function infoUser()
    {
        return $this->hasOne(InfoUser::class,'user_id','id');
    }

    public function planes()
    {
        return $this->hasMany(UserPlane::class,'user_id','id');
    }

    public function position()
    {
        return $this->hasOne(UserPosition::class,'user_id','id');
    }

    public function contract()
    {
        return $this->hasOne(UserContract::class,'user_id','id');
    }
}
