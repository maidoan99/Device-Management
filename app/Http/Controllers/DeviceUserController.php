<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddDeviceUserRequest;
use App\Repositories\Eloquents\RequestRepository;
use App\Repositories\Eloquents\DeviceUserRepository;

class DeviceUserController extends Controller
{
    protected $deviceUserRepository, $requestRepository;

    public function __construct(DeviceUserRepository $deviceUserRepository, RequestRepository $requestRepository)
    {
        $this->deviceUserRepository = $deviceUserRepository;
        $this->requestRepository = $requestRepository;
    }

    public function assign(AddDeviceUserRequest $request, $device_id, $user_id)
    {
        $data = $request->only('status', 'date', 'user_id', 'request_id');
        $this->deviceUserRepository->assignDevice($device_id, $user_id, $data);
        $this->requestRepository->updateAssign($data['request_id']);

        return redirect()->route('device.index')->with('message', 'Thông tin đã được lưu thành công');
    }
}
