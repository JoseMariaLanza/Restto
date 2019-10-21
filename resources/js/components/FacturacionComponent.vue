<template>
    <div>

        <div class="row justify-content-center">
            <!-- Factura -->
            <div class="col-md-12">
                <div class="card" style="margin-bottom:30px">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h1>Venta</h1>
                        <h1 class="d-flex">Total: $<h1 v-text="factura.Total"></h1></h1>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <div class="card" style="margin-bottom:30px">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h4>Agregar orden</h4>
                                    </div>
                                    <!-- Agregar detalles de la factura (formulario) -->
                                    <form @submit.prevent="agregar">
                                        <div class="row">
                                            <div class="col">
                                                <textarea placeholder="Descripción de la orden" class="form-control mb-2" rows="2" v-model="detalle.Descripcion"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-mb-2">
                                                <div class="input-group mb-2">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">$</span>
                                                    </div>
                                                    <input type="number" step="0.01" placeholder="Precio por unidad" class="form-control" v-model="detalle.Precio_Unitario">
                                                </div>
                                            </div>
                                            <div class="col">
                                                <input type="number" step="0.001" placeholder="Cantidad vendida" class="form-control" v-model="detalle.Cantidad">
                                            </div>
                                            <div class="col">
                                                <button type="submit" class="btn btn-primary mb-2">Agregar</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <!-- Factura -->
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h4>Información de la venta</h4>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <textarea placeholder="Mesa/Mozo/Otras descripciones" class="form-control mb-2" rows="2" v-model="factura.Descripcion"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col">
                                            <button type="submit" class="btn btn-success mb-2">Concretar venta</button>
                                        </div>
                                    </div>
                                </div>                                
                            </div>

                            <div class="col-md-8">
                                <div class="card" style="margin-bottom:30px">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h4>Detalles de la orden</h4>
                                    </div>
                                    <div class="table-responsive-sm">
                                        <!-- Detalles de la factura -->
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th class="col-ms-4">Descripción del pedido</th>
                                                    <th>Precio Unitario</th>
                                                    <th>Cantidad</th>
                                                    <th>Subtotal</th>
                                                    <th>Acción</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="item in detalles">
                                                    <td v-text="item.Descripcion"></td>
                                                    <td v-text="item.Precio_Unitario"></td>
                                                    <td v-text="item.Cantidad"></td>
                                                    <td v-text="item.Subtotal"></td>
                                                    <td><a href="" class="btn btn-danger btn-sm btn-block">Quitar</a></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
export default {
    data() {
        return {
            detalles: [],
            detalle: { Descripcion: '', Precio_Unitario: '', Candtidad: '', Subtotal: 0 },

            // No funciona el llenado automático
            fields: ['Descripcion', 'Precio_Unitario', 'Cantidad', 'Subtotal'],

            //Factura
            factura: { Tipo: '', Fecha: '', Estado: '', Total: 0.00, Descripcion: '' }
        }
    },
    methods: {
        agregar() {
            if (this.detalle.Descripcion.trim() === '' || this.detalle.Precio_Unitario === 0 || this.detalle.Cantidad === 0){
                alert('Debe completar todos los campos antes de agregar el detalle.');
                return;
            }
            const params = {
                Descripcion: this.detalle.Descripcion,
                Precio_Unitario: this.detalle.Precio_Unitario,
                Cantidad: this.detalle.Cantidad,
                Subtotal: this.detalle.Precio_Unitario * this.detalle.Cantidad
            }
            this.detalles.push(params);
            
            this.factura.Total = this.factura.Total + params.Subtotal;

            this.detalle.Descripcion = '';
            this.detalle.Precio_Unitario = '';
            this.detalle.Cantidad = '';
            
            // POST para el caso en que se concreta la venta
            // axios.past('/ventas/create', params)
            //    .then(res =>{
            //        this.factura.push(res.data)
            // })
        }
    }
}
</script>