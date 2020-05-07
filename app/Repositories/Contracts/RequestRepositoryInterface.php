<?php

namespace App\Repositories\Contracts;

interface RequestRepositoryInterface
{
    public function all();
    public function allByMe();
    public function find($id);
    public function delete($id);
    public function search(array $attributes);
    public function approveRequest($id, array $attributes);
    public function create(array $attributes);
    public function update($id, array $attributes);
}