<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';
    const MALE = 1;
    const FEMALE = 2; 
    const ADMIN = 1;
    const USER = 2;

    public function devices()
    {
        return $this->belongsToMany('App\Device', 'device_users')->withPivot('handover_at', 'released_at', 'request_id');
    }

    public function requests()
    {
        return $this->hasMany('App\Request', 'user_id', 'id');
    }

    public function leaders()
    {
        return $this->hasMany('App\Request', 'leader_id', 'id');
    }

    public function device_users()
    {
        return $this->hasMany('App\Model\DeviceUser', 'user_id', 'id');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'last_name','first_name', 'email', 'password', 'gender', 'birthday', 'address', 'avatar', 'role'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }
}
