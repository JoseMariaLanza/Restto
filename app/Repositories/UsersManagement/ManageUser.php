<?php

// DISPOSICIÓN ANTERIOR
// namespace App\Repositories;
// use App\Repositories\Users\IUsersRepository;

// ACTUAL
namespace App\Repositories\UsersManagement;

// use App\Repositories\ICRUD;
use App\User;
use App\Empleado;

class ManageUser implements IUserRepository, IEmpleadoRepository // , ICRUD
{
    /**
     * Inicialización Modelo
     * @var User
     */
    private $userModel;
    private $modeloEmpleado;

    public function __construct(User $userModel, Empleado $modeloEmpleado)
    {
        $this->userModel = $userModel;
        $this->modeloEmpleado = $modeloEmpleado;
    }

    public function getAll(){
        // return "getAll";
    }

    public function getById($id)
    {
        // return "getById";
    }

    public function create(array $user)
    {
        return $this->userModel->create($user);
    }
    
    public function crearEmpleado(array $empleado)
    {
        $this->modeloEmpleado->create($empleado);
    }

    public function update($id)
    {
        // return "update";
    }

    public function delete($id)
    {
        // return "delete";
    }
}