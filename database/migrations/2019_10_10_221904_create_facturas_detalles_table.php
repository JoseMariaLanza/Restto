<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacturasDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facturas_detalles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('Factura_Id');
            $table->foreign('Factura_Id')->references('id')->on('facturas');
            $table->unsignedBigInteger('Orden_Id')->nullable();
            $table->foreign('Orden_Id')->references('id')->on('ordenes');
            $table->float('Precio_Unitario');
            $table->float('Cantidad');
            $table->float('Subtotal');
            $table->text('Descripcion');
            $table->string('Campo_Extra_1');
            $table->string('Campo_Extra_2');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('facturas_detalles');
    }
}
