<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddDeviceRequest;
use App\Repositories\Contracts\DeviceRepositoryInterface;
use App\Repositories\Contracts\RequestRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeviceController extends Controller
{
    protected $deviceRepository, $requestRepository, $userRepository;

    public function __construct(DeviceRepositoryInterface $deviceRepository, RequestRepositoryInterface $requestRepository, UserRepositoryInterface $userRepository)
    {
        $this->deviceRepository = $deviceRepository;
        $this->requestRepository = $requestRepository;
        $this->userRepository = $userRepository;
    }

    public function myDevices()
    {
        $title = 'Thiết bị của tôi';
        $device_users = $this->deviceRepository->allByMe();

        return view('devices.myList', compact('device_users', 'title'));
    }

    public function index ()
    {
        $title = 'Danh sách thiết bị';
        $devices = $this->deviceRepository->all();
        $users = $this->userRepository->all();
        $requests = $this->requestRepository->all();

        return view('devices.lists', compact('devices', 'users', 'requests','title'));
    }

    public function search(Request $request)
    {
        $title = 'Tìm kiếm thiết bị';
        $devices = $this->deviceRepository->search($request->search);

        return view('devices.lists', compact('devices', 'title'));
    }

    public function destroy($id)
    {
        $this->deviceRepository->delete($id);
        
        return redirect()->back()->with('message', 'Xóa thành công');
    }

    public function create()
    {
        $title = 'Thêm thiết bị';
        return view('devices.add', compact('title'));
    }

    public function store(AddDeviceRequest $request)
    {
        $data = $request->all();
        $device = $this->deviceRepository->create($data);

        return redirect()->route('device.index')->with('message', 'Thông tin đã được lưu thành công'); 
    }

    public function show($id)
    {
        $title = 'Sửa thông tin thiết bị';
        $device = $this->deviceRepository->find($id);
        
        return view('devices.edit', compact('device', 'title'));
    }

    public function update(AddDeviceRequest $request, $id)
    {
        $data = $request->only('name', 'code', 'category', 'price', 'status', 'description');
        $device = $this->deviceRepository->update($id, $data);

        return redirect()->route('device.index')->with('message', 'Thông tin đã được lưu thành công');
    }

    public function devicesOfUsers()
    {
        $title = 'Danh sách thiết bị của nhân viên';
        $device_users = $this->deviceRepository->allOfUser();
        $requests = $this->requestRepository->all();

        return view('devices.listsOfUsers', compact('device_users', 'requests', 'title'));
    }

    public function release(Request $request, $device_id, $user_id)
    {
        $data = $request->only('released_at');
        $device = $this->deviceRepository->updatePivot($device_id, $user_id, $data);

        return redirect()->route('device.user.index')->with('message', 'Thông tin đã được lưu thành công');
    }

    public function getUserOfDevice($device_id)
    {
        return $this->deviceRepository->getUser($device_id);
    }

    public function getReasonOfDevice($device_id)
    {
        return $this->deviceRepository->getReason($device_id);
    }

    public function getHistoryOfDevice($device_id)
    {
        return $this->deviceRepository->getHistory($device_id);
    }


}
