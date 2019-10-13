<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Caja extends Model
{
    protected $fillable = [
        'Nombre_Caja', 'Forma_Cobro', 'Estado', 'Terminal', 'Descripcion'
    ];
}
