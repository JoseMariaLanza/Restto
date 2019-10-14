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
        return $this->modeloCaja->buscar($request->get('texto'))->orderBy('id', 'DESC')->paginate(5);
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
        $nuevaCaja->Nombre_Caja = $request->nombreCaja;
        $nuevaCaja->Forma_Cobro = $request->formaCobro;
        $nuevaCaja->Estado = $request->estado;
        $nuevaCaja->Terminal = 'Esta PC';
        $nuevaCaja->Descripcion = $request->descripcion;
        $nuevaCaja->save();

        // return $this->modeloCaja->create($caja);
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