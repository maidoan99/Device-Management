<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddUserRequest;
use App\Http\Requests\ChangePassUserRequest;
use App\Http\Requests\ChangeRoleRequest;
use App\Http\Requests\EditProfileRequest;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        $title = 'Danh sách user';
        $users = $this->userRepository->all();

        return view('users.lists', compact('users', 'title'));
    }

    public function show($id)
    {
        $title = 'Thay đổi thông tin user';
        $user = $this->userRepository->find($id);

        return view('users.edit', compact('user', 'title'));
    }

    public function update(EditProfileRequest $request, $id)
    {
        $data = $request->only('first_name', 'last_name', 'email', 'gender', 'birthday', 'address');
        $user = $this->userRepository->update($id, $data);

        return redirect()->route('user.index')->with('message', 'Thông tin đã được lưu thành công');

    }

    public function search(Request $request)
    {
        $title = 'Tìm kiếm user';
        $users = $this->userRepository->search($request->search);

        return view('users.lists', compact('users', 'title'));
    }

    public function create()
    {
        $title = 'Thêm user';
        return view('users.add', compact('title'));
    }

    public function store(AddUserRequest $request)
    {
        $data = $request->all();
        $user = $this->userRepository->create($data);

        return redirect()->route('user.index')->with('message', 'Thông tin đã được lưu thành công'); 
    }

    public function changePassword($id)
    {
        $title = 'Thay đổi mật khẩu';
        $user = $this->userRepository->find($id);

        return view('users.changePass', compact('user', 'title'));
    }

    public function updatePassword(ChangePassUserRequest $request, $id)
    {
        $data['password'] = $request->new_password;
        $user = $this->userRepository->update($id, $data);

        return redirect()->back()->with('message', 'Mật khẩu đã được thay đổi thành công');
    }

    public function changeRole($id)
    {
        $title = 'Thay đổi role';
        $user = $this->userRepository->find($id);

        return view('users.changeRole', compact('user', 'title'));
    }

    public function updateRole(ChangeRoleRequest $request, $id)
    {
        $data['role'] = $request->role;
        $user = $this->userRepository->update($id, $data);

        return redirect()->back()->with('message', 'Role đã được thay đổi thành công');
    }

    public function destroy($id)
    {
        $this->userRepository->delete($id);
        
        return redirect()->back()->with('message', 'Xóa thành công');
    }

}
