<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    protected $fillable = [
        'Nombre', 'User_Id',
    ];

    protected $dates = ['Fecha_Nacimiento'];

    public function scopeObtenerEmpleadoPorIdDeUsuario($query, $id)
    {
        $query->where('user_id', $id);
    }
}
