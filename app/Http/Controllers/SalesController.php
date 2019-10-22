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
    public function index()
    {
        // Muestra una lista de todas las ventas realizadas
        // Además se puede filtrar por fechas (entre fechas)
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
                // Obtener las ventas que se van haciendo desde la apertura de la caja
                // y pasarlas mediante compact
                $now = Carbon::now('America/Argentina/Buenos_Aires');
                $fechaInicio = $caja->Fecha_Hora_Apertura;
                // $fechaFin = $now->format('d/m/Y H:i:s');

                $facturas = Factura::buscarfacturasdia($fechaInicio)->orderBy('id', 'DESC')->paginate(5);
                
                // Pasar este código a la clase SalesManagement, dejar solamente la primera línea de abajo
                // esto se hace para que haya un objeto detallesFactura
                // $detalleFactura = new FacturaDetalle();
                // $detalleFactura->Descripcion = $request->Descripcion;
                // $detalleFactura->Precio_Unitario = $request->Precio_Unitario;
                // $detalleFactura->Cantidad = $request->Cantidad;
                // $detalleFactura->Subtotal = $detalleFactura->Precio_Unitario * $detalleFactura->Cantidad;
                
                // $detallesFactura = collect();
                // // $detallesFactura->add($detalleFactura);
                
                return view('Ventas.Crear', compact('caja', 'facturas')); //, 'detallesFactura'));
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

        return $this->salesManagement->crearFactura($request);
    }

    public function storeDetail(Request $request){
        $this->salesManagement->crearDetalleFactura($request);
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
        //
    }

    public function updateState(Request $request, $id)
    {
        if($request->Estado === 'CERRADA')
        {
            $request->validate([
                'Monto_Inicial' => 'required'
            ]);
            $request->Estado = 'ABIERTA';
            $request->Fecha_Hora_Apertura = Carbon::now();
        }
        else{
            $request->validate([
                'Monto_Final' => 'required'
            ]);
            $request->Estado = 'CERRADA';
            $request->Fecha_Hora_Cierre = Carbon::now();
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
        //
    }
}
