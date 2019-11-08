<template>
    <!-- Editar la factura -->
    <div class="row justify-content-center"> <!-- v-if="editarActivo"> -->
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
                                    <h4>Modificar orden</h4>
                                </div>
                                <!-- Editar detalles de la factura (formulario) -->
                                <form @submit.prevent="editar(factura)">
                                    
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
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Estado</button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="#" @click="modificarEstado('EMITIR')">EMITIR</a>
                                                    <a class="dropdown-item" href="#" @click="modificarEstado('ANULAR')">ANULAR</a>
                                                </div>
                                            </div>
                                            <input type="text" class="form-control" aria-label="Text input with dropdown button" v-model="factura.Estado">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <textarea placeholder="Mesa/Mozo/Otras descripciones" class="form-control mb-2" rows="2" v-model="factura.Descripcion"></textarea>
                                    </div>
                                    <input type="hidden" v-model="factura.Caja_Id">
                                </div>
                                <div class="form-row">
                                    <div class="col">
                                        <button class="btn btn-success btn-block">Guardar</button>
                                    </div>
                                    <div class="col">
                                        <button class="btn btn-default btn-block" @click="cancelarEdicion">Cancelar</button>
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
</template>

<script>
export default {
    data() {
        return {
            // // Editar
            // editarDetalles: [],
            // editarActivo: false
        }
    },
    methods: {
        editar(item, index) {
            this.editarActivo = true;
            this.factura.id = item.id;
            this.factura.Caja_Id = item.Caja_Id;
            this.factura.Tipo = item.Tipo;
            this.factura.Fecha = item.Fecha;
            this.factura.Estado = item.Estado;
            this.factura.Total = item.Total;
            this.factura.Descripcion = item.Descripcion;
            this.totalFormateado = 'Total: $' + this.factura.Total;
            console.log(this.factura.id);
            axios.get(`/ventas/showDetails/${this.factura.id}`)
            .then(res => {
                this.detalles = [];
                res.data.forEach(element => {
                this.detalles.push(element);
                });
            })
        },
        modificarEstado(estado) {
            this.factura.Estado = estado;
        },
        cancelarEdicion() {
            this.editarActivo = false;
        },
    }
}
</script>