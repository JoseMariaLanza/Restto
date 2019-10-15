<?php

namespace App\Repositories\SalesManagement;

use Illuminate\Http\Request;

use App\Repositories\SalesManagement\CashManagement\ICashRepository;
use App\CajaDetalle;
use App\Apertura;
use App\AperturaDetalle;
use App\Cierre;
use App\CierreDetalle;
use App\AperturaCierre;

class SalesManagementFacade
{
    /**
    * Inicialización de Interfaz
    * 
    * @var ICashRepository
    */
    private $manageCash;

    public function __construct(ICashRepository $manageCash)
    {
        $this->manageCash = $manageCash;
    }

    public function obtenerCajas(Request $request)
    {
        return $this->manageCash->getAll($request);
    }

    public function crearCaja(Request $request)
    {
        // $nuevaCaja = $this->manageCash->create($caja);
        // Quitar comentarios para habilitar la inserción de detalles de la caja
        // $detalle = [
        //     'Sector_Id' => $caja['sectorId'],
        //     'Descripcion' => $caja['descripcion'],
        // ];
        // $this->agregarDetalle($detalle);
        // return $nuevaCaja;
        $this->manageCash->create($request);
    }

    public function agregarDetalleCaja(CajaDetalle $detalle)
    {
        CajaDetalle::create($detalle);
    }

    public function obtenerCaja($id)
    {
        return $this->manageCash->getById($id);
    }

    public function obtenerDetallesCaja($id)
    {
        return CajaDEtalle::findOrFail($id); // Llamado desde el controlador
    }

    public function actualizarCaja($request, $id)
    {
        return $this->manageCash->update($request, $id);
    }

    public function actualizarDetallesCaja(Request $request, $id)
    {
        // $empleadoUpdate = Empleado::findOrFail($id);
        // $empleadoUpdate->Apellido = $request->Apellido;
        // $empleadoUpdate->Nombre = $request->Nombre;
        // $empleadoUpdate->Fecha_Nacimiento = $request->Fecha_Nacimiento;
        // $empleadoUpdate->Telefono = $request->Telefono;
        // $empleadoUpdate->Domicilio = $request->Domicilio;
        // $empleadoUpdate->Descripcion = $request->Descripcion;
        // $empleadoUpdate->save();
    }

    public function eliminarCaja($id)
    {
        $this->manageCash->delete($id);
    }


    // Facturación
    
}