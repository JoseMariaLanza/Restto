<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Factura extends Model
{
    protected $fillable = [
        'Caja_Id', 'Usuario_Id', 'Serie', 'Numero', 'Tipo', 'Cliente_Id', 'Fecha_Emision', 'Estado', 'Total', 'Descripcion'
    ];

    public function scopeBuscarFacturasDia($query, $fechaInicio)
    {
        $query->whereBetween('Fecha_Emision', [$fechaInicio, Carbon::now()])->get();
    }

    public function scopeBuscar($query, $fechaInicio, $fechaFin)
    {
        $query->whereBetween('Fecha_Emision', [$fechaInicio, $fechaFin])->get();
    }

}
