<?php

namespace App\Repositories\SalesManagement\InvoiceManagement;

use Illuminate\Http\Request;

interface IBillRepository
{
    public function getAll($request);

    public function getDayBills($request);

    public function getById($id);

    public function create(Request $factura);

    public function createDetail(Request $request);

    public function update(Request $request, $id);

    public function delete($id);
}