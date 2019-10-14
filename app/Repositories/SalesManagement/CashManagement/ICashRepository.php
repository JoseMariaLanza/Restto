<?php

namespace App\Repositories\SalesManagement\CashManagement;

use Illuminate\Http\Request;

interface ICashRepository
{
    public function getAll($request);

    public function getById($id);

    public function create(Request $caja);

    public function update(Request $request, $id);

    public function delete($id);
}