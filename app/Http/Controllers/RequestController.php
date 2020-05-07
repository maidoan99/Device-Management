<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddRequestRequest;
use App\Repositories\Contracts\DeviceRepositoryInterface;
use App\Repositories\Contracts\RequestRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Http\Request;

class RequestController extends Controller
{
    protected $requestRepository, $userRepository, $deviceRepository;

    public function __construct(RequestRepositoryInterface $requestRepository, UserRepositoryInterface $userRepository, DeviceRepositoryInterface $deviceRepository)
    {
        $this->requestRepository = $requestRepository;
        $this->userRepository = $userRepository;
        $this->deviceRepository = $deviceRepository;
    }

    public function myRequests()
    {
        $title = 'Yêu cầu của tôi';
        $requests = $this->requestRepository->allByMe();
        $users = $this->userRepository->all();
        $device_users = $this->deviceRepository->allOfUser();
        $devices = $this->deviceRepository->all();

        return view('requests.myList', compact('requests', 'users', 'device_users', 'devices', 'title'));
    }

    public function destroy($id)
    {
        $this->requestRepository->delete($id);
        
        return redirect()->back()->with('message', 'Xóa thành công');
    }

    public function index ()
    {
        $title = 'Danh sách yêu cầu';
        $requests = $this->requestRepository->all();
        $users = $this->userRepository->all();
        $device_users = $this->deviceRepository->allOfUser();
        $devices = $this->deviceRepository->all();

        return view('requests.lists', compact('requests', 'users', 'device_users', 'devices', 'title'));
    }

    public function search(Request $request)
    {
        $title = 'Tìm kiếm yêu cầu';
        $requests = $this->requestRepository->search($request->search);
        $users = $this->userRepository->all();
        $device_users = $this->deviceRepository->allOfUser();
        $devices = $this->deviceRepository->all();

        return view('requests.lists', compact('requests', 'users', 'device_users', 'devices', 'title'));
    }

    public function show($id)
    {
        $title = 'Sửa thông tin yêu cầu';
        $request = $this->requestRepository->find($id);
        
        return view('requests.edit', compact('request', 'title'));
    }

    public function update(AddRequestRequest $request, $id)
    {
        $data = $request->only('reason');
        $request_device = $this->requestRepository->update($id, $data);

        return redirect()->route('request.me.index')->with('message', 'Thông tin đã được lưu thành công');
    }

    public function approveRequest(Request $request, $id)
    {
        $data = $request->only('status', 'approved_at', 'leader_id');
        $request = $this->requestRepository->approveRequest($id, $data);

        return redirect()->route('request.index')->with('message', 'Thông tin đã được lưu thành công');
    }

    public function create()
    {
        $title = 'Thêm yêu cầu';
        return view('requests.add', compact('title'));
    }

    public function store(AddRequestRequest $request)
    {
        $data = $request->all();
        $request = $this->requestRepository->create($data);

        return redirect()->route('request.me.index')->with('message', 'Thông tin đã được lưu thành công');
    }

}
