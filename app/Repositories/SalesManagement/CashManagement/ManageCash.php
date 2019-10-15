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

    public function getAll($request){
        return $this->modeloCaja->buscar($request->get('texto'))->orderBy('id', 'DESC');
    }

    public function getById($id)
    {
        return $this->modeloCaja->findOrFail($id);
    }

    public function create(Request $request)
    {
        // $nuevaCaja = $this->modeloCaja->create($caja);
        // $this->modeloCaja->create($caja);

        

        $nuevaCaja = new $this->modeloCaja();
        $nuevaCaja->Nombre_Caja = $request->Nombre_Caja;
        $nuevaCaja->Forma_Cobro = $request->Forma_Cobro;
        $nuevaCaja->Estado = $request->Estado;
        $nuevaCaja->Terminal = 'Esta PC';
        $nuevaCaja->Descripcion = $request->Descripcion;
        $nuevaCaja->save();

        // return $this->modeloCaja->create($caja);
    }

    public function update(Request $request, $id)
    {
        $cajaUpdate = $this->getById($id);
        $cajaUpdate->Nombre_Caja = $request->Nombre_Caja;
        $cajaUpdate->Forma_Cobro = $request->Forma_Cobro;
        $cajaUpdate->Estado = $request->Estado;
        $cajaUpdate->Terminal = 'Esta PC';
        $cajaUpdate->Descripcion = $request->Descripcion;
        $cajaUpdate->save();
    }

    public function delete($id)
    {
        $eliminarCaja = $this->getById($id);
        $eliminarCaja->delete();
    }
}