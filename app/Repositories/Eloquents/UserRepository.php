<?php

namespace App\Repositories\Eloquents;

use App\Repositories\Contracts\UserRepositoryInterface;
use App\User;
use Exception;
use Illuminate\Support\Str;
use Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Config;

class UserRepository implements UserRepositoryInterface
{
    protected $user;
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function all()
    {
        return $this->user->paginate(Config::get('common.pagination.items_per_page'));
    }

    public function find($id)
    {
        return $this->user->findOrFail($id);
    }

    public function update($id, array $data)
    {
        $user = $this->user->findOrFail($id);
        $user->update($data);
        return $user;
    }

    public function search($value)
    {
        $user = $this->user->where('first_name', 'LIKE', '%' . $value . '%')
            ->orWhere('last_name', 'LIKE', '%' . $value . '%')
            ->orWhere('address', 'LIKE', '%' . $value . '%')
            ->orWhere('email', 'LIKE', '%' . $value . '%')
            ->paginate(Config::get('common.pagination.items_per_page'));
        return $user;
    }

    public function create(array $data)
    {
        $data['password'] = Str::random(6);

        try {
            $this->user->create($data);

            // Gui mail active gom email va password den user
            $email = $data['email'];
            \Mail::send(
                'users.mail',
                array(
                    'name' => $data['last_name'],
                    'email' => $data['email'],
                    'password' => $data['password'],
                ),
                function ($message) use ($email) {
                    $message->from('maidoan2017@gmail.com');
                    $message->to($email)->subject('Confirm sign in');
                }
            );
        } catch (Exception $e) {
            report($e);
            
            return false;
        }
    }

    public function delete($id)
    {
        try {
            $this->user->findOrFail($id)->delete();
            return true;
        } catch (Exception $e) {
            report($e);
            return false;
        }
    }
}
