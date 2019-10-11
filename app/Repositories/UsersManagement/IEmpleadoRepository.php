<?php

namespace App\Repositories\UsersManagement;

interface IEmpleadoRepository
{
    public function getAll();

    public function getById($id);

    public function create(array $empleado);

    public function update($id);

    public function delete($id);
}