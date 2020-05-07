<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditProfileRequest;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Contracts\UserRepositoryInterface;

class AdminController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function show()
    {
        $user = $this->userRepository->find(Auth::user()->id);

        return view('profile', compact('user'));
    }

    public function update(EditProfileRequest $request)
    {
        $data = $request->all();
        $user = $this->userRepository->update(Auth::user()->id, $data);

        return redirect()->back()->with('message', 'Thông tin đã được lưu thành công');

    }

}
