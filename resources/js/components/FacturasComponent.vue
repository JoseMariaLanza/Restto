<template>
<div class="container">

    <!-- Editar la factura -->
    <div class="row justify-content-center" v-if="editarActivo">
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
                            <form @submit.prevent="actualizar(factura)">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h4>Información de la venta</h4>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <select class="custom-select btn btn-outline-secondary dropdown-toggle" type="button" aria-haspopup="true" aria-expanded="false" @change="modificarEstado(factura)" v-model="factura.Estado">
                                                    <option value="EMITIDA">EMITIR</option>
                                                    <option value="ANULADA">ANULAR</option>
                                                </select>    
                                                <fieldset disabled>
                                                    <input type="text" class="form-control" aria-label="Text input with dropdown button" v-model="factura.Estado">
                                                </fieldset>
                                            </div>
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
                                                <th>Estado</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(item, index) in detalles" :key="index">
                                                <td v-text="item.Descripcion"></td>
                                                <td v-text="item.Precio_Unitario"></td>
                                                <td v-text="item.Cantidad"></td>
                                                <td v-text="'$' + item.Subtotal"></td>
                                                <td v-if="item.id > 0">
                                                    <div class="input-group mb-2">
                                                        <select class="custom-select" @change="cambiarEstadoOrden(item, index)" v-model="item.Estado">
                                                            <option value="REGISTRADA">REGISTRADA</option>
                                                            <option value="ANULADA">ANULADA</option>
                                                        </select>
                                                    </div>
                                                </td>
                                                <td v-else>
                                                    <!-- <button class="btn btn-danger btn-sm btn-block" @click="anularOrden(item, index)">Anular</button> -->
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

    <!-- Ventas -->
    <div class="row-md-10">
        <div class="panel panel-default">
            <form role="search" @submit.prevent="buscar" method="GET">
                <div class="form-row justify-content-end">
                    <div class="row">
                        <div class="row-md-2">Desde: </div>
                        <div class="col">
                            <datepicker v-model="date1" :language="es" :format="dateFormat"></datepicker>
                        </div>
                        <div class="row-md-2">Hasta: </div>
                        <div class="col">
                            <datepicker v-model="date2" :language="es" :format="dateFormat"></datepicker>
                        </div>
                        <button class="btn btn-default" type="submit">Buscar</button>
                    </div>
                </div>
            </form>
            <div class="panel-heading d-flex justify-content-between align-items-center">
                <h1>Ventas</h1>
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
                        <td>
                            <button class="btn btn-default btn-sm btn-block" @click="editar(item)">Editar</button>
                        </td>
                        <td>
                            <button class="btn btn-danger btn-sm btn-block" @click="anular(item, index)">Anular</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <div class="panel-heading d-flex justify-content-between align-items-center">
            <h1 class="d-flex" v-text="totalFinalFacturasFormateado"></h1>
        </div>

    </div>

    <div class="row justify-content-center">
        <nav class="d-flex">
            <ul class="pagination">
                <li class="page-item" v-if="pagination.current_page > 1">
                    <a class="page-link" href="#" @click.prevent="changePage(pagination.current_page - 1)">
                        <span>Anterior</span>
                    </a>
                </li>
                <li class="page-item" v-for="page in pagesNumber" :key="page" v-bind:class="[ page == isActived ? 'active' : '' ]">
                    <a class="page-link" href="#" @click.prevent="changePage(page)">
                        {{ page }}
                    </a>
                </li>
                <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                    <a class="page-link" href="#" @click.prevent="changePage(pagination.current_page + 1)">
                        <span>Siguiente</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
    
</div>
</template>

<script>
import Datepicker from 'vuejs-datepicker';
import { es } from 'vuejs-datepicker/dist/locale';

export default {
    components: {
        Datepicker
    },
    data() {
        return {

            // Detalles - Código Duplicado. Necesario para edición
            // Agregar
            detalles: [],
            detalle: { Factura_Id: '', Descripcion: '', Precio_Unitario: '', Cantidad: '', Subtotal: 0.00, Estado: '' },

            // Facturas
            facturas: [],
            factura: { Caja_Id: '', Tipo: '', Fecha: '', Estado: '', Total: 0.00, Descripcion: '' }, // Código duplicado - Necesario para edición
            // Total por página
            totalVentas: 0.00,
            totalVentasFormateado: '',
            // Total todas las páginas
            totalFinalFacturas: 0.00,
            totalFinalFacturasFormateado: '',
            // Fechas
            es: es,
            date1: new Date(),
            date2: new Date(),
            dateFormat: 'dd/MM/yyyy',

            // Paginación
            pagination: {
                'total': 0,
                'current_page': 0,
                'per_page': 0,
                'last_page': 0,
                'from': 0,
                'to': 0
            },
            offset: 3,

            // Editar - Código Duplicado. Eliminar al refactorizar sistema
            editarDetalles: [],
            editarActivo: false,

            // Edición de Ordenes
            selected: 'REGISTRADA',
            estadosOrden: [
                { text: 'REGISTRAR', value: 'REGISTRADA' },
                { text: 'ANULAR', value: 'ANULADA' }
            ]
        }
    },
    // EL FILTRADO SE REALIZA LLAMANDO AL MÉTODO BUSCAR
    // created() {
    //     // Listado de ventas del día
    //     axios.get('/ventas')
    //     .then(res => {
    //         this.facturas = res.data;
    //         console.log(res);
    //     })
    // },
    // Paginación
    computed: {
        isActived: function(){
            return this.pagination.current_page;
        },
        pagesNumber: function(){
            if(!this.pagination.to){
                return [];
            }
            var from = this.pagination.current_page - this.offset;
            if(from < 1){
                from = 1;
            }
            var to = from + (this.offset * 2)
            if(to >= this.pagination.last_page){
                to = this.pagination.last_page;
            }
            var pagesArray = [];
            while(from <= to){
                pagesArray.push(from);
                from++;
            }
            return pagesArray;
        }
    },
    methods: {
        anular(item, index) {
            axios.put(`/ventas/destroy/${item.id}`) // se llama a la función destroy pero ésta no elimina nada, sino que cambia el estado a ANULADA
            .then(res => {
                if (this.facturas[index].Estado == 'EMITIDA'){
                    this.facturas[index].Estado = res.data.Estado;
                    this.totalVentas -= this.facturas[index].Total;
                    this.totalVentasFormateado = 'Total de la página: $' + this.totalVentas;

                    this.totalFinalFacturas -= this.facturas[index].Total;
                    this.totalFinalFacturasFormateado = 'Total final: $' + this.totalFinalFacturas;
                }
            })
        },
        buscar(page) {
            this.totalVentas = 0.00;
            const params = {
                fechaInicio: this.backEndDateFormatFrom(this.date1),
                fechaFin: this.backEndDateFormatTo(this.date2),
                page: page
            }
            axios.post('/ventas/buscar', params)
            .then(res => {
                this.facturas = res.data.facturas.data;
                console.log(res.data.facturas.data);
                console.log(res.data.TotalFinalFacturas);
                this.totalFinalFacturas = res.data.TotalFinalFacturas;
                this.totalFinalFacturasFormateado = 'Total final: $' + this.totalFinalFacturas;

                // Paginación
                this.pagination = res.data.pagination;
                this.facturas.forEach(element => {
                if(element.Estado != 'ANULADA'){
                    this.totalVentas += element.Total;
                }
                })
                this.totalVentasFormateado = 'Total de la página: $' + this.totalVentas;
            })
        },
        backEndDateFormatFrom: function(date) {
            var moment = require('moment');
            return moment(date).format('Y-MM-DD 00:00:00'); // 'DD/MM/Y H:mm:ss');
        },
        backEndDateFormatTo: function(date) {
            var moment = require('moment');
            return moment(date).format('Y-MM-DD 23:23:59'); // 'DD/MM/Y H:mm:ss');
        },
        changePage: function(page){
            this.pagination.current_page = page;
            this.buscar(page);
        },
        // EDICIÓN - Código Duplicado. Eliminar al refactorizar
        editar(item) {
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
                this.detalles = res.data;
                console.log(this.detalles);
            })
        },
        modificarEstado(item) {
            this.factura.Estado = item.Estado;
            this.calcularTotalFinalFacturas(item);
        },
        cancelarEdicion() {
            this.factura.Descripcion = '';
            this.factura.Total = 0.00;
            this.totalFormateado = '';
            this.detalles = [];
            this.editarActivo = false;
        },
        actualizar(item){
            const params = {
                id: item.id,
                Tipo: item.Tipo,
                Estado: item.Estado,
                Total: item.Total,
                Descripcion: item.Descripcion
            }

            axios.put(`/ventas/update/${item.id}`, params)
               .then(res =>{
                    const index = this.facturas.findIndex(factura => factura.id === res.data.id);
                    console.log(res);
                    this.facturas[index].Tipo = res.data.Tipo;
                    this.facturas[index].Estado = res.data.Estado;
                    this.facturas[index].Descripcion = res.data.Descripcion;
                    this.facturas[index].Total = res.data.Total;

                    this.detalles.forEach(element => {
                        if(element.id === undefined){
                            element.Factura_Id = item.id;
                            axios.post('/ventas/storeDetail', element);
                        }
                        else{
                            axios.put(`/ventas/updateDetail/${element.id}`, element)
                        }
                    });
                })
                .then( res => {
                    this.factura.Descripcion = '';
                    this.factura.Total = 0.00;
                    this.totalFormateado = '';
                    this.detalles = [];
                    this.calcularTotalVentasDelDia();
                    // this.calcularTotalFinalFacturas(params); // Se llama desde el evento @change en la edición de la factura
                });
            this.editarActivo = false;
        },
        cambiarEstadoOrden(item, index){

            if (item.Estado === 'ANULADA'){
                this.factura.Total -= item.Subtotal;
            }
            else{
                this.factura.Total += item.Subtotal;
            }
            this.totalFormateado = 'Total: $' + this.factura.Total;
        },
        calcularTotalVentasDelDia(){
            this.totalVentas = 0.00;
            this.facturas.forEach(element => {
                if(element.Estado != 'ANULADA'){
                    this.totalVentas += element.Total;
                }
                this.totalVentasFormateado = 'Total ventas del día: $' + this.totalVentas;
            });
        },
        calcularTotalFinalFacturas(item){
            console.log(item);
            if(item.Estado === 'ANULADA'){
                this.totalFinalFacturas -= item.Total;
            }
            else{
                this.totalFinalFacturas += item.Total;
            }
            this.totalFinalFacturasFormateado = 'Total final: $' + this.totalFinalFacturas;
        }
    }
}
</script>