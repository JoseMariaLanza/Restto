<?php

namespace App\Repositories\StockManagement;

use Illuminate\Http\Request;

use App\Menu;

class ManageMenu implements IMenuRepository
{

    /**
     * Inicialización Modelo
     * @var Menu
     */
    private $modeloMenu;

    public function __construct(Menu $modeloMenu)
    {
        $this->modeloMenu = $modeloMenu;
    }

    public function getMenu(Request $request)
    {
        return $this->modeloMenu->buscar($request->get('texto'))->get();
    }

    public function getById($id)
    {

    }

    public function create(Request $menu)
    {

    }

    public function update(Request $request, $id)
    {

    }

    public function delete($id)
    {

    }
}