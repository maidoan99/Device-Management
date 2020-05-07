<?php

namespace App\Repositories\Eloquents;

use App\Repositories\Contracts\RequestRepositoryInterface;
use App\Request;
use App\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class RequestRepository implements RequestRepositoryInterface
{
    protected $request;
    public function __construct(Request $request, User $user)
    {
        $this->request = $request;
        $this->user = $user;
    }

    public function all()
    {
        return $this->request->paginate(Config::get('common.pagination.items_per_page'));
    }
    
    public function allByMe()
    {
        return $this->user->findOrFail(Auth::user()->id)->requests()->paginate(Config::get('common.pagination.items_per_page'));
    }

    public function find($id)
    {
        return $this->request->findOrFail($id);
    }

    public function update($id, array $data)
    {
        $request = $this->request->findOrFail($id);
        $request->update($data);
        return $request;
    }

    public function delete($id)
    {
            return $this->request->findOrFail($id)->delete();
    }

    public function search($value)
    {
        $user_id = $this->user->select('id')->where('first_name', 'LIKE', '%' . $value . '%')
            ->orWhere('last_name', 'LIKE', '%' . $value . '%')
            ->orWhere('email', 'LIKE', '%' . $value . '%')
            ->get();
        return $request = $this->request->whereIn('user_id', json_decode($user_id, true))->paginate(Config::get('common.pagination.items_per_page'));
    }

    public function approveRequest($id, array $data)
    {
        return $this->request->findOrFail($id)->update($data);
    }

    public function create(array $data)
    {
        $data['user_id'] = Auth::user()->id;
        $data['status'] = $this->request::NEW_REQUEST;

        try {
            $this->request->create($data);

        } catch (Exception $e) {
            report($e);
            
            return false;
        }
    }

    public function updateAssign($id)
    {
        $data['status'] = Config::get('common.assign.complete');
        $this->request->findOrFail($id)->update($data);
    }
}
