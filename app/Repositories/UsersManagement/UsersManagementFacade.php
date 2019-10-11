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
    
    public function crearUsuarioYEditarPerfil(array $data)
    {
        $usuario = [
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'])
        ];

        return $this->manageUser->create($usuario);
    }

    public function crearEmpleado(array $empledo)
    {
        $this->manageUser->crearEmpleado($empledo);
    }
}