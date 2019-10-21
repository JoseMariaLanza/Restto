<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FacturaDetalle extends Model
{
    protected $fillable = [
        'Factura_Id', 'Orden_Id', 'Precio_Unitario', 'Cantidad', 'Descripcion', 'Subtotal'
    ];
}
