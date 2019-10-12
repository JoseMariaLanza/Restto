<?php

namespace App\Repositories\CashManagement;

use Illuminate\Http\Request;

interface ICashRepository
{
    public function getAll();

    public function getById($id);

    public function create(array $user);

    public function update(Request $request, $id);

    public function delete($id);
}