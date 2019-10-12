<?php

namespace App\Repositories\UsersManagement;

interface IUserRepository
{
    public function getAll();

    public function getById($id);

    public function create(array $user);

    public function update(Request $request, $id);

    public function delete($id);
}