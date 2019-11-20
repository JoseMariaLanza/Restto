<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\SalesManagement\SalesManagementFacade;
use App\Repositories\SalesManagement\CashManagement\ManageBill;
use App\Caja;
use App\Factura;
use App\FacturaDetalle;

//Fechas
use Carbon\Carbon;

// Form accesible
use Collective\Html\Eloquent\FormAccessible;

class SalesController extends Controller
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('Ventas.Index');
    }

    public function buscar(Request $request)
    {
        // IMPORTANTE -> NO se llama al método get(), de hacerlo arroja error 500
        // $facturas = $this->salesManagement->obtenerFacturas($request)->paginate(5);
        // $TotalFinalFacturas = $this->salesManagement->calcularTotalVentas($facturas);
        // $facturas->add(['tot', $totalVentas]);

        $queryResult = $this->salesManagement->obtenerFacturas($request);

        $facturas = $this->salesManagement->separarFacturas($queryResult)->paginate(10);
        $TotalFinalFacturas = $this->salesManagement->separaryObtenerTotal($queryResult);

        return[
            'pagination' => [
                'total' => $facturas->total(),
                'current_page' => $facturas->currentPage(),
                'per_page' => $facturas->perPage(),
                'last_page' => $facturas->lastPage(),
                'from' => $facturas->firstItem(),
                'to' => $facturas->lastPage()
            ],
            // 'list' => [ //TODO: retornar un array con un elemento $facturas y otro totalFinalFacturas en SalesManagementFacade
            //     // y separarlo aquí en controlador para obtener las dos siguientes variables:
            //     'facturas' => $facturas, // Obtener mediante función en SalesManagementFacade
            //     'TotalFinalFacturas' => $TotalFinalFacturas // Obtener mediante función en SalesManagementFacade
            // ]
            'facturas' => $facturas,
            'TotalFinalFacturas' => $TotalFinalFacturas
        ];
        // return $facturas;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        // Consultar si la caja está abierta y pertenece a esta terminal
        // En caso de estar ABIERTA se retorna la vista de ventas
        // En caso contrario (CERRADA) se redirige a la vista de apertura de cajas
        // o bien se muestra el formulario de apertura de caja, en el cual
        // se debe ingresar el monto inicial y el estado 'ABIERTA'

        $cajas = Caja::where('Estado', 'CERRADA')->get();
        if ($cajas != null)
        {
            foreach($cajas as $caja)
            {
                if($caja->Terminal == gethostname())
                {
                    return view('Ventas.Caja.partials.formAbrir', compact('caja'))
                        ->with('mensaje', 'Debe abrir la caja para empezar a vender');
                }
            }
        }

        $cajas = Caja::where('Estado', 'ABIERTA')->get();
        foreach($cajas as $caja)
        {
            if($caja->Terminal == gethostname())
            {
                $fechaInicio = $caja->Fecha_Hora_Apertura;
                // $request->fechaInicio = $fechaInicio;
                // $fechaFin = $now->format('d/m/Y H:i:s');
                // $request->fechaFin = $fechaFin;

                if ($request->ajax()) //$request->ajax()) // ($request->isMethod('get') && $request->ajax())
                {
                    $facturas = $this->salesManagement->obtenerFacturasDelDia($fechaInicio)->get();
                    // return[
                    //     'paginate' => [
                    //         'total' => $facturas->total(),
                    //         'current_page' => $facturas->currentPage(),
                    //         'per_page' => $facturas->perPage(),
                    //         'last_page' => $facturas->lastPage(),
                    //         'from' => $facturas->firstItem(),
                    //         'to' => $facturas->lastPage()
                    //     ],
                    //     'facturas' => $facturas
                    // ];
                    return $facturas;
                }
                else
                {
                    return view('Ventas.Crear', compact('caja'));
                }
                
            }
        }
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
            'Descripcion' => 'required'
        ]);
        
        $factura = $this->salesManagement->crearFactura($request);
        $factura->Fecha_Emision = $factura->Fecha_Emision->format('Y-m-d H:i:s');
        return $factura;
    }

    public function storeDetail(Request $request){
        $this->salesManagement->crearDetalleFactura($request);
    }

    public function showDetails($facturaId){
        return $this->salesManagement->obtenerDetallesFactura($facturaId);
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
        return $this->salesManagement->updateBill($request, $id);
    }

    public function updateDetail(Request $request, $id)
    {
        // return $request;
        // $this->salesManagement->updateDetail($request, $id);
        return $this->salesManagement->updateDetail($request, $id);
    }

    public function updateState(Request $request, $id)
    {
        if($request->Estado === 'CERRADA')
        {
            $request->validate([
                'Monto_Inicial' => 'required'
            ]);
            $request->Estado = 'ABIERTA';
            $request->Fecha_Hora_Apertura = Carbon::now('America/Argentina/Buenos_Aires');
        }
        else{
            $request->validate([
                'Monto_Final' => 'required'
            ]);
            $request->Estado = 'CERRADA';
            $request->Fecha_Hora_Cierre = Carbon::now('America/Argentina/Buenos_Aires');
        }
        $this->salesManagement->updateState($request, $id);
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->salesManagement->anularFactura($id);
    }

    public function cobrar($id)
    {
        return $this->salesManagement->cobrarFactura($id);
    }

    public function getMenu()
    {
        return $this->salesManagement->getMenu();
    }

    public function searchMenuItem(Request $request)
    {
        return $this->salesManagement->buscarMenuItem($request);
    }

    public function getEmpleados()
    {
        return $this->salesManagement->obtenerEmpleados();
    }

    public function getMesas()
    {
        return $this->salesManagement->obtenerMesas()->get();
    }

    public function updateEstadoMesa(Request $request, $id)
    {
        return $this->salesManagement->actualizarEstadoMesa($request, $id)->get();
    }

    public function restoreMesa(Request $request)
    {
        return $this->salesManagement->restaurarMesa($request);
    }

    public function createMesa()
    {
        return $this->salesManagement->crearMesa();
    }

    public function updateMesa(Request $request, $id)
    {
        return $this->salesManagement->actualizarMesa($request, $id);
    }
}
