<?php

namespace App\Repositories\UsersManagement;

class UsersManagementFacade extends ManageUser
{
    /**
    * Inicialización de Interfaz
    * 
    * @var IUserRepository
    */
    private $manageUser;

    public function __construct(IUserRepository $manageUser)//ICRUD $manageUsers)
    {
        $this->manageUser = $manageUser;
    }
    
    public function crearUsuarioYEditarPerfil(array $usuario)
    {
        return $this->manageUser->create($usuario);
    }

    public function crearEmpleado(array $empledo)
    {
        $this->manageUser->crearEmpleado($empledo);
    }
}