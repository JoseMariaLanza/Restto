<?php

namespace App\Repositories\SalesManagement\InvoiceManagement;

use Illuminate\Http\Request;

use App\Factura;
use App\FacturaDetalle;

class ManageBill implements IBillRepository
{
    /**
     * Inicialización Modelo
     * @var Factura
     */
    private $modeloFactura;

    public function __construct(Factura $modeloFactura)
    {
        $this->modeloFactura = $modeloFactura;
    }

    public function getAll($request){
        // obtener todas las facuras
    }

    public function getDayBills($request)
    {
        return $this->modeloFactura->buscarfacturasdia($request->get('fechaInicio', 'fechaFin')); // ->orderBy('Fecha_Emision', 'DESC');
    }

    public function getById($id)
    {
        return $this->modeloFactura->findOrFail($id);
    }

    public function create(Request $request)
    {
        // Quitar comentarios para implementar los campos
        $nuevaFactura = new $this->modeloFactura();
        // $nuevaFactura->Caja_Id = $request->Caja_Id; // nullable - No se muestra para el ingreso
        // $nuevaFactura->Usuario_Id = $request->User_Id; // nullable - No se muestra para el ingreso
        // $nuevaFactura->Serie = $request->Serie; // nullable - No se muestra para el ingreso
        // $nuevaFactura->Numero = $request->Numero; // nullable - No se muestra para el ingreso
        $nuevaFactura->Tipo = $request->Tipo;
        // $nuevaFactura->Cliente_Id = $request->Cliente_Id; // nullable - No se muestra para el ingreso
        $nuevaFactura->Fecha_Emision = $request->Fecha_Emision;
        $nuevaFactura->Estado = $request->Estado;
        $nuevaFactura->Total = $request->Total;
        $nuevaFactura->Descripcion = $request->Descripcion;
        $nuevaFactura->save();
    }

    public function update(Request $request, $id)
    {
        // Quitar comentarios para implementar los campos
        $cajaUpdate = $this->getById($id);
        // $nuevaFactura->Caja_Id = $request->Caja_Id; // nullable - No se muestra para el ingreso
        // $nuevaFactura->Usuario_Id = $request->User_Id;  // nullable - No se muestra para el ingreso
        // $nuevaFactura->Serie = $request->Serie; // nullable - No se muestra para el ingreso
        // $nuevaFactura->Numero = $request->Numero; // nullable - No se muestra para el ingreso
        $nuevaFactura->Tipo = $request->Tipo;
        // $nuevaFactura->Cliente_Id = $request->Cliente_Id; // nullable - No se muestra para el ingreso
        $nuevaFactura->Fecha_Emision = $request->Fecha_Emision;
        $nuevaFactura->Estado = $request->Estado;
        $nuevaFactura->Total = $request->Total;
        $nuevaFactura->Descripcion = $request->Descripcion; // nullable pero si se muestra
        $cajaUpdate->save();
    }

    public function delete($id)
    {
        $eliminarCaja = $this->getById($id);
        $eliminarCaja->delete();
    }
}