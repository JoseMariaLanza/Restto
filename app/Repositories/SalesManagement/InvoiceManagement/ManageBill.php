<?php

namespace App\Repositories\SalesManagement\InvoiceManagement;

use Illuminate\Http\Request;

use App\FacturaDetalle;

class ManageBill implements IBillRepository
{
    /**
     * Inicialización Modelo
     * @var Factura
     */
    private $modeloFactura;

    public function __construct(Caja $modeloFactura)
    {
        $this->modeloFactura = $modeloFactura;
    }

    public function getAll($request){
        return $this->modeloFactura->buscar($request->get('texto'))->orderBy('id', 'DESC');
    }

    public function getById($id)
    {
        return $this->modeloFactura->findOrFail($id);
    }

    public function create(Request $request)
    {
        // $nuevaCaja = $this->modeloCaja->create($caja);
        // $this->modeloCaja->create($caja);

        

        $nuevaFactura = new $this->modeloFactura();
        $nuevaFactura->Caja_Id = $request->cajaId;
        $nuevaFactura->Usuario_Id = $request->userId;
        $nuevaFactura->Serie = $request->serie;
        $nuevaFactura->Numero = $request->numero;
        $nuevaFactura->Tipo = $request->tipo;
        $nuevaFactura->Cliente_Id = $request->clienteId;
        $nuevaFactura->Fecha_Emision = $request->fechaEmision;
        $nuevaFactura->Estado = $request->estado;
        $nuevaFactura->Total = $request->total;
        $nuevaFactura->Descripcion = $request->descripcion;
        $nuevaFactura->save();

        // return $this->modeloCaja->create($caja);
    }

    public function update(Request $request, $id)
    {
        $cajaUpdate = $this->getById($id);
        $cajaUpdate->Nombre_Caja = $request->nombreCaja;
        $cajaUpdate->Forma_Cobro = $request->formaCobro;
        $cajaUpdate->Estado = $request->estado;
        $cajaUpdate->Terminal = 'Esta PC';
        $cajaUpdate->Descripcion = $request->descripcion;
        $cajaUpdate->save();
    }

    public function delete($id)
    {
        $eliminarCaja = $this->getById($id);
        $eliminarCaja->delete();
    }
}