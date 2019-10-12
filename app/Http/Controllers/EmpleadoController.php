<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Administración de Usuarios
use App\Repositories\UsersManagement\UsersManagementFacade;
use App\Repositories\UsersManagement\ManageUsers;

class EmpleadoController extends Controller
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
        $usuarioEmpleado = auth()->user();
        $empleado = $this->usersManagement->obtenerEmpleado($usuarioEmpleado->id);
        return view('Empleado.Detalles', compact('empleado', 'usuarioEmpleado'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $usuarioEmpleado = auth()->user()->id;
        $empleado = $this->usersManagement->obtenerEmpleado($usuarioEmpleado);
        return view('Empleado.Editar', compact('empleado'));
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
            'Apellido' => 'required',
            'Nombre' => 'required'
        ]);

        $this->usersManagement->actualizarEmpleado($request, $id);

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
