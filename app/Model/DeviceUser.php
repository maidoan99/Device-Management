<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class DeviceUser extends Model
{
    protected $table = 'device_users';

    public function devices()
    {
        return $this->belongsTo('App\Device', 'device_id', 'id');
    }

    public function users()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function requests()
    {
        return $this->belongsTo('App\Request', 'request_id', 'id');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'device_id', 'request_id', 'handover_at', 'released_at'
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
