<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mesa extends Model
{
    protected $fillable = [
        'Numero', 'Descripcion'
    ];

    public function scopeBuscar($query)
    {
        $query->where('Estado', 'LIBRE');
    }
}
