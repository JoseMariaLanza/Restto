<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Users Management
use App\Repositories\UsersManagement\UsersManagementFacade;
use App\Repositories\UsersManagement\ManageUsers;

class UsuarioController extends Controller
{
    /**
     * Inicialización de Fachada
     * 
     * @var UsersManagementFacade
     */
    private $usersManagement;

    public function __construct(UsersManagementFacade $usersManagement)
    {
        $this->middleware('auth');
        $this->usersManagement = $usersManagement;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $usuario = $this->usersManagement->obtenerEmpleado($id);
        $empleado = $this->usersManagement->obtenerEmpleado($id);
        return view('Usuario.Editar', compact('usuario', 'empleado'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required'
        ]);

        // $usuarioUpdate = $this->usersManagement->obtenerUsuario($id);
        $this->usersManagement->actualizarUsuario($request, $id);
        // $usuarioUpdate = User::findOrFail($id);
        // $usuarioUpdate->name = $request->name;
        // $usuarioUpdate->email = $request->email;
        // $usuarioUpdate->save();

        return back()->with('mensaje', 'Cambios guardados correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
