<template>
    <div>

        <div class="row justify-content-center">
            <!-- Factura -->
            <div class="col-md-12">
                <div class="card" style="margin-bottom:30px">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h1>Venta</h1>
                        <h1 class="d-flex" v-text="totalFormateado"></h1>
                    </div>
                    <div class="card-body-mb-2">
                        <div class="row">
                            <div class="col">
                                <div class="card" style="margin-bottom:20px">
                                    <div class="card-header d-flex">
                                        <h4>Agregar orden</h4>
                                    </div>
                                    <!-- Agregar detalles de la factura (formulario) -->
                                    <form @submit.prevent="agregar">
                                        
                                        <div class="form-row">
                                            <div class="form-group col-md-8">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">$</span>
                                                    </div>
                                                    <input type="number" step="0.01" min="0.01" placeholder="Precio por unidad" class="form-control" v-model="detalle.Precio_Unitario">
                                                </div>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <input type="number" step="0.001" min="0.001" placeholder="Cantidad" class="form-control" v-model="detalle.Cantidad">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col">
                                                <textarea placeholder="Descripción de la orden" class="form-control mb-2" rows="2" v-model="detalle.Descripcion"></textarea>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <button type="submit" class="btn btn-primary btn-block">Agregar</button>
                                        </div>
                                    </form>
                                </div>

                                <!-- Factura -->
                                <form @submit.prevent="guardar">
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h4>Información de la venta</h4>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <textarea placeholder="Mesa/Mozo/Otras descripciones" class="form-control mb-2" rows="2" v-model="factura.Descripcion"></textarea>
                                        </div>
                                        <input type="hidden" v-model="factura.Caja_Id">
                                    </div>
                                    <div class="form-row">
                                        <div class="col">
                                            <button class="btn btn-success btn-block">Concretar venta</button>
                                        </div>
                                    </div>
                                </div>      
                                </form>                          
                            </div>

                            <div class="col-md-8">
                                <div class="card" style="margin-bottom:30px">
                                    <div class="card-header">
                                        <h4>Detalles de la orden</h4>
                                    </div>
                                    <div class="table-responsive">
                                        <!-- Detalles de la factura -->
                                        <table class="table table-hover">
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
                                                <tr v-for="(item, index) in detalles" :key="index">
                                                    <td v-text="item.Descripcion"></td>
                                                    <td v-text="item.Precio_Unitario"></td>
                                                    <td v-text="item.Cantidad"></td>
                                                    <td v-text="'$' + item.Subtotal"></td>
                                                    <!-- <td><a href="" class="btn btn-danger btn-sm btn-block">Quitar</a></td> -->
                                                    <td>
                                                        <button class="btn btn-danger btn-sm btn-block" @click="quitar(item, index)">Quitar</button>
                                                    </td>
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

        <!-- Ventas del día -->
        <div class="container">
            <div class="row-md-10">
                <div class="panel panel-default">
                    <div class="panel-heading d-flex justify-content-between align-items-center">
                        <h1>Ventas del día</h1>
                        <h1 class="d-flex" v-text="totalVentasFormateado"></h1>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="table-responsive">
                    <!-- Detalles de la factura -->
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th class="col-ms-4">Nº de Factura</th>
                                <th>Descripción</th>
                                <th>Fecha y Hora de la venta</th>
                                <th>Total</th>
                                <th>Estado</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, index) in facturas" :key="index">
                                <td v-text="item.id"></td>
                                <td v-text="item.Descripcion"></td>
                                <td v-text="item.Fecha_Emision"></td>
                                <td v-text="'$' + item.Total"></td>
                                <td v-text="item.Estado"></td>
                                <!-- <td><a href="" class="btn btn-danger btn-sm btn-block">Quitar</a></td> -->
                                <td>
                                    <button class="btn btn-danger btn-sm btn-block" @click="anular(item, index)">Anular</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
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
            detalle: { Factura_Id: '', Descripcion: '', Precio_Unitario: '', Cantidad: '', Subtotal: 0.00 },

            // Colección de facturas registradas en el día
            facturas: [],
            // Total de ventas en el día
            totalVentas: 0.00,
            // Total de ventas formateado para mostrar al usuario
            totalVentasFormateado: '',
            //Factura
            factura: { Caja_Id: '', Tipo: '', Fecha: '', Estado: '', Total: 0.00, Descripcion: '' },
            totalFormateado: ''
        }
    },
    created() {
        // Obteniendo el id de la caja abierta para definir la foreign key
        var caja_id = document.getElementById('cajaId');
        this.factura.Caja_Id = caja_id.value;
        // Listado de ventas del día
        axios.get('/ventas/create')
            .then(res => {
                this.facturas = res.data;
                this.facturas.forEach(element => {
                if(element.Estado != 'ANULADA'){
                    this.totalVentas += element.Total;
                }
                })
                this.totalVentasFormateado = 'Total ventas del día: $' + this.totalVentas;
            })
    },
    methods: {
        agregar() {
            if (this.detalle.Descripcion.trim() === '' || 
            this.detalle.Precio_Unitario === '0' || this.detalle.Cantidad === '0' ||
            this.detalle.Precio_Unitario === '' || this.detalle.Cantidad === ''){
                alert('Debe completar todos los campos antes de agregar el detalle.');
                return;
            }
            if (this.detalle.Precio_Unitario > 2000000 ||
            this.detalle.Cantidad > 2000000){
                alert('Límite excedido, el número es muy elevado');
                return;
            }
            const params = {
                Descripcion: this.detalle.Descripcion,
                Precio_Unitario: this.detalle.Precio_Unitario,
                Cantidad: this.detalle.Cantidad,
                Subtotal: this.detalle.Precio_Unitario * this.detalle.Cantidad
            }
            if (params.Subtotal > 2000000){
                alert('El valor del subtotal es muy elevado');
                return;
            }
            this.detalles.unshift(params);
            
            this.factura.Total = this.factura.Total + params.Subtotal;
            this.totalFormateado = 'Total: $' + this.factura.Total;

            this.detalle.Descripcion = '';
            this.detalle.Precio_Unitario = '';
            this.detalle.Cantidad = '';
        },
        guardar() {
            if (this.detalles.length <= 0 || this.factura.Descripcion === '') {
                alert('Ingrese los detalles de la venta');
                return;
            }
            const params = {
                Descripcion: this.factura.Descripcion,
                Total: this.factura.Total,
                Caja_Id: this.factura.Caja_Id
            }
            this.factura.Descripcion = '';
            this.factura.Total = 0.00;
            this.totalFormateado = '';
            axios.post('/ventas/store', params)
               .then(res =>{
                    this.facturas.unshift(res.data);
                    this.totalVentas += params.Total;
                    this.totalVentasFormateado = 'Total ventas del día: $' + this.totalVentas;
                    this.detalles.forEach(element => {
                        element.Factura_Id = res.data.id;
                        axios.post('/ventas/storeDetail', element);
                        this.detalles = [];
                   });
                })
            
        },
        quitar(item, index) {
            this.factura.Total = this.factura.Total - item.Subtotal;
            this.totalFormateado = 'Total: $' + this.factura.Total;
            this.detalles.splice(index, 1);
        },
        anular(item, index) {
            axios.put(`/ventas/destroy/${item.id}`)
            .then(res => {
                if (this.facturas[index].Estado == 'EMITIDA'){
                    this.facturas[index].Estado = res.data.Estado;
                    this.totalVentas -= this.facturas[index].Total;
                    this.totalVentasFormateado = 'Total ventas del día: $' + this.totalVentas;
                }
            })
        }
    }
}
</script>