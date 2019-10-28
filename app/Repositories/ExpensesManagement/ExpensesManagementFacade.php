<?php

namespace App\Repositories\ExpensesManagement;

use Illuminate\Http\Request;

use App\Repositories\ExpensesManagement\IExpenseRepository;

class ExpensesManagementFacade
{
    /**
    * Inicialización de Interfaz
    * 
    * @var IExpenseRepository
    */
    private $manageExpense;

    public function __construct(IExpenseRepository $manageExpense)
    {
        $this->manageExpense = $manageExpense;
    }

    public function obtenerGastos(Request $request)
    {
        return $this->manageExpense->getAll($request);
    }

    public function obtenerEnums()
    {
        return $this->manageExpense->getEnums();
    }

    public function crearGasto(Request $request)
    {
        $this->manageExpense->create($request);
    }

    public function actualizarGasto($request, $id)
    {
        return $this->manageExpense->update($request, $id);
    }

    public function eliminarGasto($id)
    {
        return $this->manageExpense->delete($id);
    }
}