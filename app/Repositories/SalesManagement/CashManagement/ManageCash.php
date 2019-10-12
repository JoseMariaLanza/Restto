<?php

namespace App\Repositories\SalesManagement\CashManagement;

use Illuminate\Http\Request;

use App\Caja;

class ManageCash implements ICashRepository
{
    /**
     * Inicialización Modelo
     * @var Caja
     */
    private $modeloCaja;

    public function __construct(Caja $modeloCaja)
    {
        $this->modeloCaja = $modeloCaja;
    }

    public function getAll(){
        // return "getAll";
    }

    public function getById($id)
    {
        return $this->modeloCaja->findOrFail($id);
    }

    public function create(array $caja)
    {
        return $this->modeloCaja->create($caja);
    }

    public function update(Request $request, $id)
    {
        $cajaUpdate = $this->getById($id);
        $cajaUpdate->NombreCaja = $request->nombreCaja;
        $cajaUpdate->FormaCobro = $request->formaCobro;
        $cajaUpdate->Estado = $request->estado;
        $cajaUpdate->Terminal = $request->terminal;
        $cajaUpdate->Descripcion = $request->descripcion;
        $cajaUpdate->save();
    }

    public function delete($id)
    {
        // return "delete";
    }
}