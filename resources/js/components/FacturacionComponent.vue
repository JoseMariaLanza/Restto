<template>
    <div>

        <!-- <factura-edicion v-if="editarActivo"></factura-edicion> -->
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
                                            <div class="form-group col-md-12">
                                                <div class="col">
                                                    <label for="busq" class="col col-form-label">Búsqueda</label>
                                                    <input class="form-control mb-2" type="text" @keyup="llenarCombobox" v-model="buscar" placeholder="Buscar..." id="busq">
                                                    <!-- <input type="number" step="0.001" min="0.001" placeholder="Cantidad" class="form-control" v-model="detalle.Cantidad"> -->
                                                </div>
                                            </div>
                                            <!-- <div class="col-md-6">
                                                <label for="menus" class="col col-form-label">Menú:</label>
                                                <select class="custom-select mb-2" @change="establecerItem" v-model="platoArticuloMenu" id="menus" size="4">
                                                    <option :value="platoArticuloMenu" id="selectedItemDefaultId" selected>Seleccionar...</option>s
                                                    <option v-for="(platoArticuloMenu, index) in menu" :key="index" :value="platoArticuloMenu" 
                                                    :id="platoArticuloMenu.id + platoArticuloMenu.Nombre_Plato">{{ platoArticuloMenu.Nombre_Plato }}</option>
                                                </select>
                                            </div> -->
                                        </div>

                                        <div class="form-row">
                                            <div class="col-md-12">
                                                <label for="menus" class="col col-form-label">Menú:</label>
                                                <select class="custom-select mb-2" @change="establecerItem" v-model="platoArticuloMenu" id="menus" size="4">
                                                    <!-- <option :value="platoArticuloMenu" id="selectedItemDefaultId" selected>Seleccionar...</option>s -->
                                                    <option v-for="(platoArticuloMenu, index) in menu" :key="index" :value="platoArticuloMenu" 
                                                    :id="platoArticuloMenu.id + platoArticuloMenu.Nombre_Plato">{{ platoArticuloMenu.Nombre_Plato }}</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="cant" class="col col-form-label">Cantidad</label>
                                                <input type="number" step="0.001" min="0.001" placeholder="Cantidad" class="form-control" v-model="detalle.Cantidad" id="cant">
                                            </div>
                                            <div class="form-group col-md-6 mb-2">
                                                <label for="prec" class="col col-form-label">Precio</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">$</span>
                                                    </div>
                                                    <input type="number" step="0.01" min="0.01" placeholder="Precio" class="form-control" v-model="detalle.Precio_Unitario" id="prec">
                                                </div>
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
                                                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Estado</button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" href="#" v-on:click.prevent="modificarEstado('EMITIR')">EMITIR</a>
                                                        <a class="dropdown-item" href="#" v-on:click.prevent="modificarEstado('ANULAR')">ANULAR</a>
                                                    </div>
                                                </div>
                                                <fieldset disabled>
                                                    <input type="text" class="form-control" aria-label="Text input with dropdown button" v-model="factura.Estado">
                                                </fieldset>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <textarea disabled placeholder="Mesa/Mozo/Otras descripciones" class="form-control mb-2" rows="2" v-model="factura.Descripcion"></textarea>
                                        </div>
                                        <input type="hidden" v-model="factura.Caja_Id">
                                    </div>
                                    <div class="form-row">
                                        <div class="col">
                                            <button class="btn btn-success btn-block">Guardar</button>
                                        </div>
                                        <div class="col">
                                            <button class="btn btn-default btn-block" @click="limpiar">Cancelar</button>
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

        <!-- Agregar nueva Factura -->
        <div class="row justify-content-center" v-else>
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
                                            <div class="form-group col-md-12">
                                                <div class="col">
                                                    <label for="busq" class="col col-form-label">Búsqueda</label>
                                                    <input class="form-control mb-2" type="text" @keyup="llenarCombobox" v-model="buscar" placeholder="Buscar..." id="busq">
                                                    <!-- <input type="number" step="0.001" min="0.001" placeholder="Cantidad" class="form-control" v-model="detalle.Cantidad"> -->
                                                </div>
                                            </div>
                                            <!-- <div class="col-md-6">
                                                <label for="menus" class="col col-form-label">Menú:</label>
                                                <select class="custom-select mb-2" @change="establecerItem" v-model="platoArticuloMenu" id="menus" size="4">
                                                    <option :value="platoArticuloMenu" id="selectedItemDefaultId" selected>Seleccionar...</option>s
                                                    <option v-for="(platoArticuloMenu, index) in menu" :key="index" :value="platoArticuloMenu" 
                                                    :id="platoArticuloMenu.id + platoArticuloMenu.Nombre_Plato">{{ platoArticuloMenu.Nombre_Plato }}</option>
                                                </select>
                                            </div> -->
                                        </div>

                                        <div class="form-row">
                                            <div class="col-md-12">
                                                <label for="menus" class="col col-form-label">Menú:</label>
                                                <select class="custom-select mb-2" @change="establecerItem" v-model="platoArticuloMenu" id="menus" size="4">
                                                    <option id="selectedItemDefaultId" selected>Seleccione un item...</option>s
                                                    <option v-for="(platoArticuloMenu, index) in menu" :key="index" :value="platoArticuloMenu" 
                                                    :id="platoArticuloMenu.id + platoArticuloMenu.Nombre_Plato">{{ platoArticuloMenu.Nombre_Plato }}</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="cant" class="col col-form-label">Cantidad</label>
                                                <input type="number" step="0.001" min="0.001" placeholder="Cantidad" class="form-control" v-model="detalle.Cantidad" id="cant">
                                            </div>
                                            <div class="form-group col-md-6 mb-2">
                                                <label for="prec" class="col col-form-label">Precio</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">$</span>
                                                    </div>
                                                    <input type="number" step="0.01" min="0.01" placeholder="Precio" class="form-control" v-model="detalle.Precio_Unitario" id="prec">
                                                </div>
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

                                    <div class="form-group">
                                        <!-- <div class="form-row">
                                            <label for="mesas" class="col-md-3 col-form-label">Mesas</label>
                                            
                                            <div class="col">
                                                <form @submit.prevent="crearNuevaMesa">
                                                    <button class="btn btn-success form-control mb-2">Agregar una nueva mesa</button>
                                                </form>
                                            </div>
                                            
                                        </div> -->
                                        <label for="mesas" class="col-md-3 col-form-label">Mesas</label>
                                        <div class="col">
                                            <select class="custom-select" id="mesas" v-model="mesa">
                                                <!-- <option :value="mesa" selected>Seleccionar...</option> -->
                                                <option v-for="(mesa, index) in mesas" :key="index" :value="mesa" :id="mesa.id">{{ mesa.Descripcion }}</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="sector" class="col-md-12 col-form-label">Ingrese el sector</label>
                                        <div class="col">
                                            <input placeholder="Sector" class="form-control" v-model="sector">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="mozos" class="col-md-4 col-form-label">Mozo</label>
                                        <div class="col">
                                            <select class="custom-select" id="mozos" v-model="mozo">
                                                <option value="" selected>Seleccionar...</option>
                                                <option v-for="(mozo, index) in empleados" :key="index" :value="mozo.Nombre + ' ' + mozo.Apellido" :id="mozo.id">{{ mozo.Nombre + " " + mozo.Apellido }}</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- <div class="row">
                                        <div class="col-md-12">
                                            <textarea placeholder="Mesa/Mozo/Otras descripciones" class="form-control mb-2" rows="2" v-model="factura.Descripcion"></textarea>
                                        </div>
                                        <input type="hidden" v-model="factura.Caja_Id">
                                    </div> -->
                                    <div class="form-row">
                                        <div class="col">
                                            <button class="btn btn-success btn-block">Guardar</button>
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
                        <tbody id="tableDataFacturas">
                            <tr v-for="(item, index) in facturas" :key="index" :id="index">
                                <td v-text="item.id"></td>
                                <td v-text="item.Descripcion"></td>
                                <td v-text="item.Fecha_Emision"></td>
                                <td v-text="'$' + item.Total"></td>
                                <td v-text="item.Estado"></td>
                                <td>
                                    <button class="btn btn-default btn-sm btn-block" @click="editar(item)">Editar</button>
                                </td>
                                <td v-if="item.Estado === 'EN EMISIÓN'">
                                    <!-- <button class="btn btn-danger btn-sm btn-block" @click="anular(item, index)">Anular</button> -->
                                    <button class="btn btn-success btn-sm btn-block" @click="checkIn(item, index)">Cobrar</button>
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
            // Agregar
            detalles: [],
            detalle: { Factura_Id: '', Descripcion: '', Precio_Unitario: '', Cantidad: 1, Subtotal: 0.00, Estado: '' },

            // Mostrar
            // Colección de facturas registradas en el día
            facturas: [],
            // Total de ventas en el día
            totalVentas: 0.00,
            // Total de ventas formateado para mostrar al usuario
            totalVentasFormateado: '',

            // Guardar
            // Factura
            factura: { Caja_Id: '', Tipo: '', Fecha: '', Estado: '', Total: 0.00, Descripcion: '' },
            totalFormateado: '',

            // Ventas facturadas
            esconder: false,

            // Editar
            editarDetalles: [],
            editarActivo: false,

            // Edición de Ordenes
            selected: 'REGISTRADA',
            estadosOrden: [
                { text: 'REGISTRAR', value: 'REGISTRADA' },
                { text: 'ANULAR', value: 'ANULADA' }
            ],

            // MENU
            menu: [],
            buscar: '',
            platoArticuloMenu: { Nombre_Plato: '', Precio_Venta: 0.00,  },

            // EMPLEADOS
            empleados: [],
            mozo: '',

            // MESAS
            mesas: [],
            mesa: { Numero: '', Estado: '', Descripcion: '' },
            sector: ''
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
                if(element.Estado === 'FACTURADA'){
                    this.totalVentas += element.Total;
                }
            })
            this.totalVentasFormateado = 'Total ventas del día: $' + this.totalVentas;
        })
        // OCULTANDO FACTURAS CON EL ESTADO = FACTURADA
        .then(res => {
            var tableFacturas = document.getElementById('tableDataFacturas');
            for (var i = 0, row; row = tableFacturas.rows[i]; i++){
                for (var j = 0, col; col = row.cells[j]; j++) {
                    if(row.cells[j].innerText === 'FACTURADA'){
                        tableFacturas.rows[i].style.display = "none";
                    }
                }
            }
        })

        axios.post('/ventas/getEmpleados')
        .then(res => {
            this.empleados = res.data;
        })

        axios.post('/ventas/getMesas')
        .then(res => {
            this.mesas = res.data;
        })

        axios.post('/ventas/getMenu')
        .then(res => {
            this.menu = res.data;
        })
    },
    methods: {
        establecerItem() {
            this.detalle.Descripcion = this.platoArticuloMenu.Nombre_Plato;
            this.detalle.Precio_Unitario = this.platoArticuloMenu.Precio_Venta;
            this.detalle.Cantidad = 1;
        },
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
            console.log(this.detalles);
            
            this.factura.Total = this.factura.Total + params.Subtotal;
            this.totalFormateado = 'Total: $' + this.factura.Total;

            // this.detalle.Descripcion = '';
            // this.detalle.Precio_Unitario = '';
            // this.detalle.Cantidad = '';
        },
        crearNuevaMesa() {
            axios.post('/ventas/createMesa')
            .then(res => {
                var desc = 'Mesa ' + res.data.id;
                const params = {
                    Numero: res.data.id,
                    Descripcion: desc,
                    Estado: 'LIBRE'
                }
                axios.put(`/ventas/updateMesa/${res.data.id}`, params)
                .then(res => {
                    this.mesas.push(res.data);
                })
            })
        },
        guardar() {
            // Esta se llenará sí o sí al Seleccionar las Descripciones
            // if (this.detalles.length <= 0 || this.factura.Descripcion === '') {
            //     alert('Ingrese los detalles de la venta');
            //     return;
            // }
            if (this.detalles.length <= 0)
            {
                alert('Ingrese los detalles de la venta');
                return;
            }
            if (this.mesa == '' || this.sector == '' || this.mozo == '' ||
            this.mesa == undefined || this.sector == undefined || this.mozo == undefined)
            {
                alert('Seleccione una mesa, su sector y el mozo encargado de la atención');
                return;
            }
            this.factura.Descripcion = this.mesa.Descripcion + ' // Sector: ' + this.sector + ' // Mozo: ' + this.mozo;
            const params = {
                Descripcion: this.factura.Descripcion,
                Total: this.factura.Total,
                Caja_Id: this.factura.Caja_Id
            }
            this.factura.Estado = '';
            this.factura.Descripcion = '';
            this.factura.Total = 0.00;
            this.totalFormateado = '';
            axios.post('/ventas/store', params)
            .then(res =>{
                this.facturas.unshift(res.data);
                // SE QUITA la funcionalidad de realizar el cálculo ya que éste se realizará al momento de hacer el cobro
                // this.totalVentas += params.Total;
                // this.totalVentasFormateado = 'Total ventas del día: $' + this.totalVentas;
                this.detalles.forEach(element => {
                    element.Factura_Id = res.data.id;
                    axios.post('/ventas/storeDetail', element);
                    this.detalles = [];
               });
            })

            this.ocuparMesa(this.mesa);
            // this.mesa.Estado = 'OCUPADA';
            // axios.put(`/ventas/updateEstadoMesa/${this.mesa.id}`, this.mesa)
            // .then(res => {
            //     const index = this.mesas.findIndex(mesa => mesa.id === res.data.id);
            //     this.mesas.splice(index, 1);
            // })
        },
        ocuparMesa(mesa) {
            mesa.Estado = 'OCUPADA';
            axios.put(`/ventas/updateEstadoMesa/${mesa.id}`, mesa)
            .then(res => {
                const index = this.mesas.findIndex(mesa => mesa.id === res.data.id);
                this.mesas.splice(index, 1);
            })
        },
        llenarCombobox() {
            this.menu = [];
            const params = {
                texto: this.buscar
            }
            axios.post('/ventas/searchMenuItem', params)
            .then(res => {
                this.menu = res.data;
                // document.getElementById('menus').selectedIndex = 1;
                
                // const index = this.menu.findIndex(item => res.data[1].Nombre_Plato.toLowerCase().includes(params.texto));
                // var menuItems = document.getElementById(this.menu[index].id + this.menu[index].Nombre_Plato);
                // menuItems.selected = true;

                var menuItems = document.getElementById('menus'); // this.menu[index]);
                // document.getElementById('selectedItemDefaultId').selected = false;
                // console.log(menuItems);

                // var menuItemId = '';

                for (var i = 0; i < menuItems.options.length; i++) {
                    if (menuItems.options[0].text.toLowerCase().includes(params.texto)) {
                        // menuItemId = menuItems.options[i].id;
                        console.log(menuItems.options[0]);
                        menuItems.options[i].selected = true;
                        // console.log(menuItemId);
                        // document.getElementById(menuItemId).selected = true;
                        return;
                    }
                }

                // console.log(menuItemId);
                // document.getElementById(menuItemId).selected = true;

            })
        },
        quitar(item, index) {
            this.factura.Total = this.factura.Total - item.Subtotal;
            this.totalFormateado = 'Total: $' + this.factura.Total;
            this.detalles.splice(index, 1);
        },
        // Función sin uso, porque la acción de anular la factura ya está implementada a la hora de
        // editar ésta
        // anular(item, index) {
        //     axios.put(`/ventas/destroy/${item.id}`)
        //     .then(res => {
        //         if (this.facturas[index].Estado == 'EMITIDA'){
        //             this.facturas[index].Estado = res.data.Estado;
        //             this.totalVentas -= this.facturas[index].Total;
        //             this.totalVentasFormateado = 'Total ventas del día: $' + this.totalVentas;
        //         }
        //     })
        // },
        checkIn(item, index) {
            // var boleta = document.getElementById(index);
            // boleta.style.display = "none";
            // SOLO ACTUALIZA EL ESTADO
            axios.put(`/ventas/cobrar/${item.id}`)
            .then(res => {
                this.facturas[index].Estado = res.data.Estado;
            })
            .then(res => {
                var boleta = document.getElementById(index);
                boleta.style.display = "none";
                this.calcularTotalVentasDelDia();
                this.limpiar();
            })

            this.restaurarMesa(index, 'LIBRE');
            
            // // this.mesa.Estado = 'LIBRE';
            // console.log(this.facturas[index].Descripcion);

            // const table = {
            //     Estado: 'LIBRE',
            //     texto: this.facturas[index].Descripcion
            // }

            // axios.post('/ventas/restoreMesa', table)
            // .then(res => {
            //     this.mesas.push(res.data[0]);
            //     axios.put(`/ventas/updateEstadoMesa/${res.data[0].id}`, table)
            // })
        },
        // RESTAURAR MESA
        restaurarMesa(index, estado) {
            var est = estado;
            const table = {
                Estado: est, //'LIBRE', --> CONTINUAR AQUÍ, pasa Estado como undefinied
                texto: this.facturas[index].Descripcion
            }
            console.log(table);
            axios.post('/ventas/restoreMesa', table)
            .then(res => {
                if (this.facturas[index].Estado ==='ANULADA' || this.facturas[index].Estado === 'FACTURADA'){
                        console.log('en if anulada');
                        // this.restaurarMesa(index, 'LIBRE');
                        this.mesas.push(res.data[0]);
                    }
                    else{
                        console.log('en if en emisión');
                        // this.restaurarMesa(index, 'OCUPADA');
                        this.mesas.splice(res.data[0], 1);
                    }
                // this.mesas.push(res.data[0]);
                axios.put(`/ventas/updateEstadoMesa/${res.data[0].id}`, table)
                .then(res => {
                    console.log(res);
                })
            })
        },
        // EDICIÓN
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
        modificarEstado(estado) {
            if (estado === 'EMITIR'){
                this.factura.Estado = 'EN EMISIÓN';
            }
            else{
                this.factura.Estado = 'ANULADA';
            }
        },
        limpiar() {
            this.factura.Descripcion = '';
            this.factura.Total = 0.00;
            this.totalFormateado = '';
            this.detalles = [];
            this.editarActivo = false;

            //LIMPIAR CMBX
            this.mesa = '';
            this.mozo = '';
        },
        actualizar(item){
            const params = {
                id: item.id,
                Tipo: item.Tipo,
                Estado: item.Estado,
                Total: item.Total,
                Descripcion: item.Descripcion //this.mesa + ' // ' + this.sector + ' // ' + this.mozo + ' // ' + item.Descripcion
            }

            axios.put(`/ventas/update/${item.id}`, params)
               .then(res =>{
                    const index = this.facturas.findIndex(factura => factura.id === res.data.id);
                    
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

                    this.restaurarMesa(index);

                    // if (params.Estado ==='ANULADA'){
                    //     console.log('en if anulada');
                    //     this.restaurarMesa(index, 'LIBRE');
                    // }
                    // else{
                    //     console.log('en if en emisión');
                    //     this.restaurarMesa(index, 'OCUPADA');
                    //     // this.ocuparMesa(this.mesa);
                    // }
                })
                .then( res => {
                    this.factura.Descripcion = '';
                    this.factura.Total = 0.00;
                    this.totalFormateado = '';
                    this.detalles = [];
                    this.calcularTotalVentasDelDia();
                    this.limpiar();
                });
            this.editarActivo = false;
        },
        cambiarEstadoOrden(item, index){

            if (item.Estado === 'FACTURADA'){
                this.factura.Total += item.Subtotal;
            }
            else{
                this.factura.Total -= item.Subtotal;
            }
            this.totalFormateado = 'Total: $' + this.factura.Total;
        },
        calcularTotalVentasDelDia(){
            this.totalVentas = 0.00;
            this.facturas.forEach(element => {
                if(element.Estado === 'FACTURADA'){
                    this.totalVentas += element.Total;
                }
                this.totalVentasFormateado = 'Total ventas del día: $' + this.totalVentas;
            });
        }
    }
}
</script>