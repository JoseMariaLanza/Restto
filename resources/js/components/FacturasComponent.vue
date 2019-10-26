<template>
<div class="container">
    <div class="row-md-10">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h1>Ventas</h1>
                <form role="search" @submit.prevent="buscar" method="GET">
                    <div class="form-row justify-content-end">
                        <div class="row">
                            <div class="row-md-2">Buscar entre</div>
                            <div class="col">
                                <datepicker v-model="date1" :language="es" :format="dateFormat"></datepicker>
                            </div>
                            <div class="row-md-2">y</div>
                            <div class="col">
                                <datepicker v-model="date2" :language="es" :format="dateFormat"></datepicker>
                            </div>
                            <button class="btn btn-default" type="submit">Buscar</button>
                            <!-- @click="buscar(date1, date2)" -->
                        </div>
                    </div>
                </form>
                <form role="search" class="navban-form navbar-left pull-right" method='GET'>
                    <div class="form-row" style="margin-bottom:30px">
                        <!-- AGREGAR DOS COMPONENTES DATETIMEPICKER -->
                        <!-- FILTRADO DE FACTURAS POR FECHA -->
                        
                        
                        <!-- LA BÚSQUEDA SE HARÁ CON SOLO SELECCIONAR LAS FECHAS -->

                        <!-- <div class="form-group">
                            <h5>Buscar entre</h5>
                        </div>
                        <div class="form-goup">
                            <div class="col">
                                <div class='input-group date' id='fInicio' name="fechaInicio">
                                    <input type='text' class="form-control" />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <h5>y</h5>
                        </div>
                        <div class="form-group">
                            <div class="col">
                                <div class='input-group date' id='fFin' name="fechaFin">
                                    <input type='text' class="form-control" />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                        <button type="submit" class="btn btn-default">Buscar</button>
                        </div> -->
                    </div>
                </form>
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
            // Fechas
            es: es,
            date1: new Date(),
            date2: new Date(),
            dateFormat: 'dd/MM/yyyy',
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
    methods: {
        anular(item, index) {
            axios.put(`/ventas/destroy/${item.id}`) //'/ventas/destroy', item.id``)
            .then(res => {
                this.facturas[index].Estado = res.data.Estado;
            })
        },
        buscar() {
            const params = {
                fechaInicio: this.backEndDateFormatFrom(this.date1),
                fechaFin: this.backEndDateFormatTo(this.date2)
            }
            console.log(params);
            axios.post('/ventas/buscar', params)
            .then(res => {
                this.facturas = res.data;
            })
        },
        backEndDateFormatFrom: function(date) {
            var moment = require('moment');
            return moment(date).format('Y-MM-DD 00:00:00'); // 'DD/MM/Y H:mm:ss');
        },
        backEndDateFormatTo: function(date) {
            var moment = require('moment');
            return moment(date).format('Y-MM-DD 23:23:59'); // 'DD/MM/Y H:mm:ss');
        }
    }
}
</script>