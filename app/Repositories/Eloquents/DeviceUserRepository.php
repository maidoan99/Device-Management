<?php

namespace App\Repositories\Eloquents;

use App\Model\DeviceUser;
use Exception;
use Illuminate\Support\Facades\Config;

class DeviceUserRepository
{
    protected $device_user;

    public function __construct(DeviceUser $device_user)
    {
        $this->device_user = $device_user;
    }

    public function assignDevice($device_id, $user_id, array $data)
    {
        $device_user['device_id'] = $device_id;
        $device_user['user_id'] = $user_id;
        $device_user['request_id'] = $data['request_id'];

        if ($data['status'] == Config::get('common.assign.handover')) {
            $device_user['handover_at'] = $data['date'];

        } else if ($data['status'] == Config::get('common.assign.release')) {
            $device_user['released_at'] = $data['date'];
        }

        try {
            $this->device_user->where('request_id', $data['request_id'])->update($device_user);
        } catch (Exception $e) {
            report($e);
            
            return false;
        }
    }

}
