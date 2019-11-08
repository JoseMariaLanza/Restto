<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Administración de Cajas
use App\Repositories\ExpensesManagement\ExpensesManagementFacade;

use Carbon\Carbon;

class GastoController extends Controller
{
    /**
     * Inicialización de Fachada
     * 
     * @var ExpensesManagementFacade
     */
    private $expensesManagement;

    public function __construct(ExpensesManagementFacade $expensesManagement)
    {
        $this->middleware('auth');
        $this->expensesManagement = $expensesManagement;
    }

    public function index(Request $request)
    {
        $queryResult = $this->expensesManagement->obtenerGastos($request);
        $periodos = $this->expensesManagement->obtenerEnums();
        $gastos = $this->expensesManagement->separarGastos($queryResult)->paginate();
        $totalGastos = $this->expensesManagement->separaryObtenerTotal($queryResult);

        return view('Gasto.Index', compact('gastos', 'periodos', 'totalGastos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'Concepto' => 'required',
            'Monto' => 'required',
            'Periodo' => 'required',
            'Descripcion' => 'required'
        ]);
        // $request->request->add(['Fecha']);
        // $request->Fecha = Carbon::now();

        $this->expensesManagement->crearGasto($request);

        return back()->with('mensaje', 'Gasto agregado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->expensesManagement->eliminarGasto($id);
        return back()->with('mensaje', 'Gasto eliminado correctamente');
    }
}
