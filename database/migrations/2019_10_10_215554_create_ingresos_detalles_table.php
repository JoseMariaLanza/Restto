<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIngresosDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingresos_detalles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('Ingreso_Id');
            $table->foreign('Ingreso_Id')->references('id')->on('ingresos');
            $table->unsignedBigInteger('Articulo_Id')->nullable();
            $table->foreign('Articulo_Id')->references('id')->on('articulos');
            $table->float('Precio_Costo');
            $table->float('Precio_Venta');
            $table->dateTime('Fecha_Produccion')->nullable();
            $table->dateTime('Fecha_Vencimiento')->nullable();
            $table->float('Cantidad');
            $table->float('Subtotal');
            // $table->unsignedBigInteger('Ubicacion_Id')->nullable();
            // $table->foreign('Ubicacion_Id')->references('id')->on('ubicaciones')->nullable();
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
        Schema::dropIfExists('ingresos_detalles');
    }
}
