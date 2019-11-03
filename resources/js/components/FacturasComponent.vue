<template>
<div class="container">
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
            // Facturas
            facturas: [],
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
        }
    }
}
</script>