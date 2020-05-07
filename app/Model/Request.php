<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    protected $table = 'requests';
    
    const NEW_REQUEST = 1;
    const APPROVED = 2;
    const REJECTED = 3;
    const COMPLETED = 4;

    public function users()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function leaders()
    {
        return $this->belongsTo('App\User', 'leader_id', 'id');
    }

    public function device_users()
    {
        return $this->hasMany('App\Model\DeviceUser', 'request_id', 'id');
    }

    protected $dates = [
        'created_at', 'approved_at', 'updated_at'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'reason', 'status', 'approved_at', 'leader_id', 'created_at', 'updated_at'
    ];
}
