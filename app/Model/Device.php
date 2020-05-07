<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $table = 'devices';
    const MOUSE = 1;
    const KEYBOARD = 2;
    const LAPTOP = 3;
    const CASE = 4;
    const SCREEN = 5;
    const CAMERA = 6;
    const PHONE = 7;

    const TRONG_KHO = 1;
    const DANG_SD = 2;
    const THANH_LY = 3;

    const HONDOVER = 1;
    const RELEASE = 2;

    public function users()
    {
        return $this->belongsToMany('App\User', 'device_users')->withPivot('handover_at', 'released_at', 'request_id');
    }

    public function device_users()
    {
        return $this->hasMany('App\Model\DeviceUser', 'device_id', 'id');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code', 'name', 'description', 'price', 'category', 'status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
    ];

}
