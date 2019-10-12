<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    protected $fillable = [
        'Nombre', 'User_Id',
    ];

    protected $dates = ['Fecha_Nacimiento'];
}
