<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Contracts\UserRepositoryInterface;
class ChangePasswordController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    public function show()
    {
        return view('auth.passwords.change');
    }

    public function update(ChangePasswordRequest $request)
    {
        $data['password'] = $request->new_password;
        $user = $this->userRepository->update(Auth::user()->id, $data);
        // User::where('id', Auth::user()->id)->update(['password' => bcrypt($request->new_password)]);
        return redirect()->back()->with('message', 'Mật khẩu đã được thay đổi thành công');
    }

}
