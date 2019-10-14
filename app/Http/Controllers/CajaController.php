<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Administración de Cajas
use App\Repositories\SalesManagement\SalesManagementFacade;
use App\Repositories\SalesManagement\CashManagement\ManageCash;

class CajaController extends Controller
{
    /**
     * Inicialización de Fachada
     * 
     * @var SalesManagementFacade
     */
    private $salesManagement;

    public function __construct(SalesManagementFacade $salesManagement)
    {
        $this->middleware('auth');
        $this->salesManagement = $salesManagement;
    }

    public function index(Request $request)
    {
        // Producto::buscar($request->get('texto'))->orderBy('id', 'DESC')->paginate(5);
        $cajas = $this->salesManagement->obtenerCajas($request);
        return view('Ventas.Caja.Index', compact('cajas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        // $this->salesManagement->crearCaja([
        //     'Nombre_Caja' => $data['nombreCaja'],
        //     'Forma_Cobro' => $data['formaCobro'],
        //     'Estado' => $data['estado'],
        //     'Terminal' => 'MI PC',
        //     'Descripcion' => $data['descripcion']
        // ]);

        $this->salesManagement->crearCaja($request);

        return back()->with('mensaje', 'Caja agregada correctamente');
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
        $caja = $this->salesManagement->obtenerCaja($id);
        // TODO: Obtener detalles de la caja.
        return view('Caja.Mostrar', compact('caja')); // , 'cajaDetalles');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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
