<?php

namespace App\Repositories\SalesManagement;

use Illuminate\Http\Request;

use App\Repositories\SalesManagement\CashManagement\ICashRepository;
use App\Repositories\SalesManagement\InvoiceManagement\IBillRepository;
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
    * @var IBillRepository
    */
    private $manageCash;
    private $manageBill;

    public function __construct(ICashRepository $manageCash, IBillRepository $manageBill)
    {
        $this->manageCash = $manageCash;
        $this->manageBill = $manageBill;
    }

    public function obtenerCajas(Request $request)
    {
        return $this->manageCash->getAll($request);
    }

    public function obtenerCajaDeTerminal(Request $request)
    {
        return $this->manageCash->getByTerminal($request);
    }

    public function crearCaja(Request $request)
    {
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
        return CajaDetalle::findOrFail($id); // Llamado desde el controlador
    }

    public function actualizarCaja($request, $id)
    {
        return $this->manageCash->update($request, $id);
    }

    public function updateState(Request $request, $id)
    {
        $this->manageCash->updateState($request, $id);
    }

    public function actualizarDetallesCaja(Request $request, $id)
    {
        // No implementado
    }

    public function eliminarCaja($id)
    {
        $this->manageCash->delete($id);
    }

    // Facturación
    
    public function obtenerFacturas(Request $request)
    {
        return $this->manageBill->getBills($request);
    }

    // public function obtenerFacturas($fechaInicio, $fechaFin)
    // {
    //     return $this->manageBill->getBills($fechaInicio, $fechaFin);
    // }

    public function obtenerFacturasDelDia($fechaInicio)
    {
        return $this->manageBill->getDayBills($fechaInicio);
    }

    public function crearFactura(Request $request)
    {
        return $this->manageBill->create($request);
    }

    public function crearDetalleFactura(Request $request)
    {
        $this->manageBill->createDetail($request);
    }

    public function anularFactura($id)
    {
        return $this->manageBill->delete($id);
    }
}