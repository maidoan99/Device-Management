<?php

namespace App\Repositories\Eloquents;

use App\Repositories\Contracts\DeviceRepositoryInterface;
use App\Device;
use App\Model\DeviceUser;
use App\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class DeviceRepository implements DeviceRepositoryInterface
{
    protected $device, $user, $device_user;
    public function __construct(Device $device, User $user, DeviceUser $device_user)
    {
        $this->device = $device;
        $this->user = $user;
        $this->device_user = $device_user;
    }

    public function allByMe()
    {
        try {
            return $this->device_user->where('user_id', Auth::user()->id)->where('released_at', NULL)->paginate(Config::get('common.pagination.items_per_page'));
        } catch (Exception $e) {
            report($e);
            return false;
        }
    }

    public function all()
    {
        return $this->device->paginate(Config::get('common.pagination.items_per_page'));
    }

    public function allOfUser()
    {
        return $this->device_user->with('devices', 'users')->paginate(Config::get('common.pagination.items_per_page'));
    }

    public function find($id)
    {
        try {
            return $this->device->findOrFail($id);
        } catch (Exception $e) {
            report($e);
            return false;
        }
    }

    public function search($value)
    {
        $device = $this->device->where('code', 'LIKE', '%' . $value . '%')
            ->orWhere('name', 'LIKE', '%' . $value . '%')
            ->paginate(Config::get('common.pagination.items_per_page'));
        return $device;
    }

    public function delete($id)
    {
        try {
            $this->device->findOrFail($id)->delete();
            return true;
        } catch (Exception $e) {
            report($e);
            return false;
        }
    }

    public function createCodeDevice($category_id)
    {
        $codes = $this->device->where('category', $category_id)->get();
        $codeNumber = count($codes) + 1;

        return $code = Config::get('common.code.' . $category_id) . str_pad($codeNumber, 3, "0", STR_PAD_LEFT);;
    }

    public function create(array $data)
    {
        $category_id = $data['category'];
        $data['code'] = $this->createCodeDevice($category_id);

        try {
            $this->device->create($data);

        } catch (Exception $e) {
            report($e);
            
            return false;
        }
    }

    public function update($id, array $data)
    {
        $device = $this->device->findOrFail($id);
        $device->update($data);
        return $device;
    }

    public function updatePivot($device_id, $user_id, array $data)
    {
        return $this->device->findOrFail($device_id)->users()->updateExistingPivot($user_id, $data);
    }

    public function getUser($device_id)
    {
        $device = $this->device->findOrFail($device_id);
        $device_user = $device->device_users->where('released_at', NULL);

        if (count($device_user) != 0) {
            $user_id = $device_user->first()->user_id;    
            return response()->json(array('user'=> $user_id), 200);
        } else {
            return null;
        }
    }

    public function getReason($device_id)
    {
        $device = $this->device->findOrFail($device_id);
        $device_user = $device->device_users->where('released_at', NULL);

        if (count($device_user) != 0) {
            $request_id = $device_user->first()->request_id;
            return response()->json(array('reason'=> $request_id), 200);
        } else {
            return null;
        }
    }

    public function getHistory($device_id)
    {
        $data = array();
        $device_users = $this->device_user->where('device_id', $device_id)->get();
        if (count($device_users) != 0) {
            foreach ($device_users as $device_user) {
                $user_id = $device_user->user_id;
                $user = $this->user->find($user_id)->first_name . ' ' . $this->user->find($user_id)->last_name;
                $handover_at = $device_user->handover_at;
                $released_at = $device_user->released_at;
                $data[] = array('user'=> $user, 'handover_at' => $handover_at, 'released_at' => $released_at);
            }
            
            return response()->json($data, 200);
        } else {
            return null;
        }
    }

}
