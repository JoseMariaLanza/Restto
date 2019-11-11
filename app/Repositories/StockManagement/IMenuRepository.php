<?php

namespace App\Repositories\StockManagement;

use Illuminate\Http\Request;

interface IMenuRepository
{
    public function getMenu(Request $request);

    public function getById($id);

    public function create(Request $menu);

    public function update(Request $request, $id);

    public function delete($id);
}