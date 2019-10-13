<?php

namespace App\Repositories\SalesManagement\CashManagement;

use Illuminate\Http\Request;

interface ICashRepository
{
    public function getAll();

    public function getById($id);

    public function create(array $caja);

    public function update(Request $request, $id);

    public function delete($id);
}