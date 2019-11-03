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
        return $query->whereBetween('Fecha_Emision', [$fechaInicio, Carbon::now()]);
    }

    public function scopeBuscar($query, $fechaInicio, $fechaFin)
    {
        // $fechaInicio = $fechaInicio->format('d/m/Y H:i:s');
        // $fechaFin = $fechaFin->format('d/m/Y H:i:s');

        $query->whereBetween('Fecha_Emision', [$fechaInicio, $fechaFin])->get();
    }

}
