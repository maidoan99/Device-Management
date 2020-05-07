<?php

namespace App\Repositories\Contracts;

interface DeviceRepositoryInterface
{
    public function all();
    public function allByMe();
    public function allOfUser();
    public function find($id);
    public function search(array $attributes);
    public function create(array $attributes);
    public function update($id, array $attributes);
    public function updatePivot($device_id, $user_id, array $attributes);
    public function delete($id);
    public function createCodeDevice($category_id);
    public function getUser($device_id);
    public function getReason($device_id);
    public function getHistory($device_id);
}