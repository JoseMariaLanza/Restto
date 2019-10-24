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
                                                    <input type="number" step="0.01" min="0.01" placeholder="Precio por unidad" class="form-control" v-model="detalle.Precio_Unitario">
                                                </div>
                                            </div>
                                            <div class="col">
                                                <input type="number" step="0.001" min="0.001" placeholder="Cantidad vendida" class="form-control" v-model="detalle.Cantidad">
                                            </div>
                                            <div class="col">
                                                <button type="submit" class="btn btn-primary mb-2">Agregar</button>
                                            </div>
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
                                            <button class="btn btn-success mb-2">Concretar venta</button>
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
                                                <tr v-for="(item, index) in detalles" :key="index">
                                                    <td v-text="item.Descripcion"></td>
                                                    <td v-text="item.Precio_Unitario"></td>
                                                    <td v-text="item.Cantidad"></td>
                                                    <td v-text="item.Subtotal"></td>
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

    </div>
</template>

<script>
export default {
    data() {
        return {
            detalles: [],
            detalle: { Factura_Id: '', Descripcion: '', Precio_Unitario: '', Cantidad: '', Subtotal: '' },

            // Colección de facturas registradas en el día
            facturas: [],
            //Factura
            factura: { Caja_Id: '', Tipo: '', Fecha: '', Estado: '', Total: 0.00, Descripcion: '' },
            totalFormateado: ''
        }
    },
    // En componente que lista las ventas
    // created() {
    //     axios.get('/ventas/create')
    //         .then(res => {
    //             this.facturas = res.data;
    //         })
    // },
    methods: {
        agregar() {
            if (this.detalle.Descripcion.trim() === '' || 
            this.detalle.Precio_Unitario === '0' || this.detalle.Cantidad === '0' ||
            this.detalle.Precio_Unitario === '' || this.detalle.Cantidad === ''){
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
            this.totalFormateado = 'Total: $' + this.factura.Total;

            this.factura.Caja_Id = app.$refs.caja_id.value;

            console.log(this.factura.Caja_Id);

            this.detalle.Descripcion = '';
            this.detalle.Precio_Unitario = '';
            this.detalle.Cantidad = '';
            
            // POST para el caso en que se concreta la venta
            // axios.post('/ventas', factura)
            //    .then(res =>{
            //        this.facturas.push(res.data)
            // })
        },
        guardar() {
            if (this.detalles.length <= 0 || this.factura.Descripcion === '') {
                alert('Ingrese los detalles de la venta');
                return;
            }
            const params = {
                Descripcion: this.factura.Descripcion,
                Total: this.factura.Total
            }
            this.factura.Descripcion = '';
            this.factura.Total = '';
            this.totalFormateado = '';
            axios.post('/ventas/store', params)
               .then(res =>{
                   this.facturas.push(res.data);
                   this.detalles.forEach(element => {
                       element.Factura_Id = res.data.id;
                       axios.post('/ventas/storeDetail', element);
                       this.detalles = [];
                   });
                })
            
            // alert('Venta guardada correctamente');
            
        },
        quitar(item, index) {
            this.factura.Total = this.factura.Total - item.Subtotal;
            this.totalFormateado = 'Total: $' + this.factura.Total;
            this.detalles.splice(index, 1);
        }
    }
}
</script>