<template>
    <div>
        <!-- Editar la factura -->
        <div class="row justify-content-center" v-if="editarActivo">
            <div class="col-md-12">
                <div class="card" style="margin-bottom:30px">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h1>Venta</h1>
                    </div>
                    <form @submit.prevent="actualizar(factura)">
                        <div class="form-row p-2">
                            <div class="col-auto">
                                <div class="form-group">
                                    <div class="input-group">
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
                            <div class="col">
                                <div class="form-group">
                                    <input disabled placeholder="Mesa/Mozo/Otras descripciones" class="form-control mb-2" rows="2" v-model="factura.Descripcion">
                                    <input type="hidden" v-model="factura.Caja_Id">
                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- Editar detalles de la factura (formulario) -->
                    <form @submit.prevent="agregar">
                        <div class="form-inline p-2">
                            <div class="form-group">
                                <label for="busq" class="my-1 mr-2">Buscar</label>
                                <input class="form-control my-1 mr-sm-2" type="text" @keyup="llenarCombobox" v-model="buscar" placeholder="Buscar..." id="busq">
                            </div>
                        </div>
                        <div class="form-inline p-2">
                            <div class="form-group">
                                <label for="menus" class="my-1 mr-2">Menú:</label>
                                <select class="custom-select my-1 mr-sm-2" @change="establecerItem" v-model="platoArticuloMenu" id="menus">
                                    <option id="selectedItemDefaultId" selected>Seleccione un item...</option>s
                                    <option v-for="(platoArticuloMenu, index) in menu" :key="index" :value="platoArticuloMenu" 
                                    :id="platoArticuloMenu.id + platoArticuloMenu.Nombre_Plato">{{ platoArticuloMenu.Nombre_Plato }}</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="cant" class="my-1 mr-2">Cantidad</label>
                                <input type="number" step="0.001" min="0.001" placeholder="Cantidad" class="form-control my-1 mr-sm-2"
                                v-model="detalle.Cantidad" id="cant">
                            </div>
                            <input type="hidden" step="0.01" min="0.01" placeholder="Precio" class="form-control my-1 mr-sm-2" 
                            v-model="detalle.Precio_Unitario" id="prec">
                            <input type="hidden" placeholder="Descripción de la orden" class="form-control my-1 mr-sm-2"
                            rows="2" v-model="detalle.Descripcion">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-block">Agregar</button>
                            </div>
                        </div>
                    </form>
                    
                    <div class="card">
                        <div class="card-header">
                            <h4>{{ mesa.Descripcion }}</h4>
                        </div>
                        <div class="table-responsive">
                            <!-- Detalles de la factura -->
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th class="col-ms-4">Descripción del pedido</th>
                                        <th>$ por Unidad</th>
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

                    <p class="h1 text-right" v-text="totalFormateado"></p>

                    <div class="form-inline">
                        <div class="form-inline p-2">
                            <button type="button" @click.prevent="limpiar" class="btn btn-danger btn-flex">Cancelar</button>
                        </div>
                        <div class="form-inline p-2">
                            <button type="button" @click.prevent="actualizar(factura)" class="btn btn-success btn-flex">Guardar</button>
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
                    </div>
                    <!-- Factura -->
                    <!-- <form> @submit.prevent="guardar"> -->
                    <form @submit.prevent="guardar">
                        <div class="form-inline p-2">
                            <div class="form-group">
                                <label for="mesas" class="my-1 mr-2">Mesas</label>
                                <select class="custom-select my-1 mr-sm-2" id="mesas" v-model="mesa">
                                    <!-- <option :value="mesa" selected>Seleccione una mesa</option> -->
                                    <option v-for="(mesa, index) in mesas" :key="index" :value="mesa" :id="mesa.id">{{ mesa.Descripcion }}</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="sector" class="my-1 mr-2">Ingrese el sector</label>
                                <input placeholder="Sector" class="form-control my-1 mr-sm-2" v-model="sector">
                            </div>
                            
                            <div class="form-group">
                                <label for="mozos" class="my-1 mr-2">Mozo</label>
                                <select class="custom-select my-1 mr-sm-2" id="mozos" v-model="mozo">
                                    <option value="" selected>Seleccione al mozo</option>
                                    <option v-for="(mozo, index) in empleados" :key="index" :value="mozo.Nombre + ' ' + mozo.Apellido" :id="mozo.id">{{ mozo.Nombre + " " + mozo.Apellido }}</option>
                                </select>
                            </div>
                        </div>
                    </form>
                                            
                    <form @submit.prevent="agregar">
                        <div class="form-inline p-2">
                            <div class="form-group">
                                <label for="busq" class="my-1 mr-2">Buscar</label>
                                <input class="form-control my-1 mr-sm-2" type="text" @keyup="llenarCombobox" v-model="buscar" placeholder="Buscar..." id="busq">
                            </div>
                        </div>
                        
                        <div class="form-inline p-2">
                            <div class="form-group">
                                <label for="menus" class="my-1 mr-2">Menú:</label>
                                <select class="custom-select my-1 mr-sm-2" @change="establecerItem" v-model="platoArticuloMenu" id="menus">
                                    <option id="selectedItemDefaultId" selected>Seleccione un item...</option>s
                                    <option v-for="(platoArticuloMenu, index) in menu" :key="index" :value="platoArticuloMenu" 
                                    :id="platoArticuloMenu.id + platoArticuloMenu.Nombre_Plato">{{ platoArticuloMenu.Nombre_Plato }}</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="cant" class="my-1 mr-2">Cantidad</label>
                                <input type="number" step="0.001" min="0.001" placeholder="Cantidad" class="form-control my-1 mr-sm-2"
                                 v-model="detalle.Cantidad" id="cant">
                            </div>

                            <input type="hidden" step="0.01" min="0.01" placeholder="Precio" class="form-control my-1 mr-sm-2" 
                            v-model="detalle.Precio_Unitario" id="prec">

                            <input type="hidden" placeholder="Descripción de la orden" class="form-control my-1 mr-sm-2"
                            rows="2" v-model="detalle.Descripcion">

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-block">Agregar</button>
                            </div>
                        </div>
                    </form>

                    
                        <div class="card">
                            <div class="card-header">
                                <h4>{{ mesa.Descripcion }}</h4>
                            </div>
                            <div class="table-responsive">
                                <!-- Detalles de la factura -->
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th class="col-ms-4">Descripción del pedido</th>
                                            <th>$ por Unidad</th>
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
                    
                    <p class="h1 text-right" v-text="totalFormateado"></p>

                    <div class="form-inline">
                        <div class="form-inline p-2">
                            <button type="button" @click.prevent="limpiar" class="btn btn-danger btn-flex">Borrar todo</button>
                        </div>
                        <div class="form-inline p-2">
                            <button type="button" @click.prevent="guardar" class="btn btn-success btn-flex">Guardar</button>
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
                        <!-- NO MOSTRAR -->
                        <!-- <h1 class="d-flex" v-text="totalVentasFormateado"></h1> -->
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
                                    <button class="btn btn-default btn-sm btn-inline" @click="editar(item)">Modificar</button>
                                </td>
                                <td v-if="item.Estado === 'EN EMISIÓN'">
                                    <button class="btn btn-danger btn-sm btn-inline mb-2" @click="anular(item, index)">Anular</button>
                                    <!-- Original sin modal -->
                                    <!-- <button class="btn btn-success btn-sm btn-inline mb-2" @click="cobrar(item, index)">Cobrar</button> -->
                                    <button class="btn btn-success btn-sm btn-inline mb-2" data-toggle="modal" data-target="#modalFormaPago"
                                    @click="cobrarModal(item, index)">Cobrar</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
            </div>
        </div>

        <!-- POPUP MODAL BOOTSTRAP -->
        <!-- Establecer forma de cobro -->

        <!-- Ejemplo de boton Mostrar Modal -->
        <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">Open modal for @mdo</button> -->

        <div class="modal fade" id="modalFormaPago" tabindex="-1" role="dialog" aria-labelledby="modalFormaPagoLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalFormaPagoLabel">Forma de Pago</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                <div class="form-group">
                    <!-- <label for="recipient-name" class="col-form-label">Seleccione la forma de pago:</label>
                    <input type="text" class="form-control" id="recipient-name"> -->
                    <select class="custom-select my-1 mr-sm-2" v-model="formaPago" id="facturaFormaPago">
                        <option value="" selected>Seleccione una opción</option>
                        <option value="EFECTIVO">EFECTIVO</option>
                        <option value="TARJETA">TARJETA</option>
                    </select>
                </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" @click="cobrar(cobrarItem, cobrarIndex)" data-dismiss="modal">Aceptar</button>
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
            factura: { Caja_Id: '', Tipo: '', Fecha: '', Estado: '', Total: 0.00, Descripcion: '', Forma_Pago: '' },
            totalFormateado: '',
            // Variables para que el modal funcione correctamente
            cobrarItem: '',
            cobrarIndex: '',
            formaPago: '',

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
            console.log(this.facturas);
            this.facturas.forEach(element => {
                if(element.Estado === 'FACTURADA'){
                    this.totalVentas += element.Total;
                }
            })
            this.totalVentasFormateado = 'Total ventas del día: $' + this.totalVentas;
        })
        // OCULTANDO FACTURAS CON EL ESTADO = FACTURADA
        .then(res => {
            this.ocultarFacturadas();
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
        ocultarFacturadas() {
            var tableFacturas = document.getElementById('tableDataFacturas');
            for (var i = 0, row; row = tableFacturas.rows[i]; i++){
                for (var j = 0, col; col = row.cells[j]; j++) {
                    if(row.cells[j].innerText === 'FACTURADA'){
                        tableFacturas.rows[i].style.display = "none";
                    }
                }
            }
        },
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
                Estado: this.factura.Estado,
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
                    axios.post('/ventas/storeDetail', element)
                    .then(res=> {
                        this.detalles = [];
                    })
               });
            })
            .then(res => {
                this.ocultarFacturadas();
            })

            this.mesa.Estado = 'OCUPADA';
            const index = this.mesas.findIndex(mesa => mesa.id === this.mesa.id);
            this.mesas.splice(index, 1);
            axios.put(`/ventas/updateEstadoMesa/${this.mesa.id}`, this.mesa)
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
        anular(item, index) {
            if (confirm('¿Está seguro que desea anular esta venta?.') == false)
            {
                return;
            }
            axios.put(`/ventas/destroy/${item.id}`)
            .then(res => {
                console.log(res);
                if (this.facturas[index].Estado == 'EN EMISIÓN'){
                    this.facturas[index].Estado = res.data.Estado;
                    this.totalVentas -= this.facturas[index].Total;
                    this.totalVentasFormateado = 'Total ventas del día: $' + this.totalVentas;
                }
                this.actualizarEstadoMesa(index, 'LIBRE');
            })
        },
        cobrar(item, index) { // se pasan las variables cobrarItem y cobrarIndex
            // SE DESACTIVA PORQUE YA SE CONFIRMA CON EL MODAL
            // if (confirm('¿Está seguro que desea realizar el cobro?.') == false)
            // {
            //     return;
            // }

            if (this.formaPago === '')
            {
                alert('Debe especificar la forma de pago');
                return;
            }
            const params = {
                Forma_Pago: this.formaPago
            }

            axios.put(`/ventas/cobrar/${item.id}`, params)
            .then(res => {
                this.facturas[index].Estado = res.data.Estado;
                this.facturas[index].Forma_Pago = res.data.Forma_Pago;
            })
            .then(res => {
                this.actualizarEstadoMesa(index, 'LIBRE');
                var boleta = document.getElementById(index);
                boleta.style.display = "none";
                this.calcularTotalVentasDelDia();
                this.limpiar();
            })
            .then(res => {
                this.ocultarFacturadas();
            })

            this.cobrarItem = '';
            this.cobrarIndex = '';
        },
        cobrarModal(item, index) {
            this.cobrarItem = item;
            this.cobrarIndex = index;
        },
        // ACTUALIZAR EL ESTADO DE LA MESA
        actualizarEstadoMesa(index, estado) {
            this.mesa.Estado = estado;
            const table = {
                Estado: this.mesa.Estado,
                texto: this.facturas[index].Descripcion,
                EstadoFactura: this.facturas[index].Estado
            }
            
            // console.log('estado Factura ' + this.facturas[index].Estado); // si devuelve el estado

            axios.post('/ventas/restoreMesa', table)
            .then(res => {
                // console.log('Resultado restoreMesa ' + res.data[0]); // devuelve un object
                // console.log('Estado restoreMesa: ' + this.facturas[index].Estado); // no devuelve el estado

                if (this.facturas[index].Estado ==='ANULADA' || this.facturas[index].Estado === 'FACTURADA'){
                    console.log('entrada al if restoreMesa');
                    var containMesa = false;
                    this.mesas.forEach(element => {
                        if (element.id === res.data[0].id){
                            containMesa = true;
                        }
                    });
                    if (containMesa === false){
                        this.mesas.push(res.data[0]);
                        axios.put(`/ventas/updateEstadoMesa/${res.data[0].id}`, table)
                        .then(res=> {
                            console.log('entrada al if anulada facturada');
                            console.log(res);
                        })
                    }
                }
                else{
                    var containMesa = false;
                    this.mesas.forEach(element => {
                        if (element.id === res.data[0].id){
                            containMesa = true;
                        }
                    });
                    if (containMesa === true){
                        console.log('mesa en else ' + res.data[0]);
                        const index = this.mesas.findIndex(mesa => mesa.id === res.data[0].id);
                        this.mesas.splice(index, 1);
                        axios.put(`/ventas/updateEstadoMesa/${res.data[0].id}`, table)
                        .then(res=> {
                            console.log('entrada al else anulada facturada');
                            console.log(res);
                        })
                    }
                }
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
                // console.log(this.detalles);
            })
            if (this.factura.Estado === 'EN EMISIÓN'){
                this.mesa.Estado = 'OCUPADA';
            }
            else{
                this.mesa.Estado = 'LIBRE';
            }
            console.log(this.mesa);
        },
        modificarEstado(estado) {
            if (estado === 'EMITIR'){
                this.factura.Estado = 'EN EMISIÓN';
                this.mesa.Estado = 'OCUPADA';
            }
            else{
                this.factura.Estado = 'ANULADA';
                this.mesa.Estado = 'LIBRE';
            }
        },
        limpiar() {
            if (this.detalles.length > 0)
            {
                if (confirm('¿Está seguro que desea cancelar la operación?.') == false)
                {
                    return;
                }
            }
            this.factura.Descripcion = '';
            this.factura.Total = 0.00;
            this.totalFormateado = '';
            this.detalles = [];
            this.editarActivo = false;

            //LIMPIAR CMBX
            // this.mesa = '';
            // this.mozo = '';
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

                    this.actualizarEstadoMesa(index, this.mesa.Estado);

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

            if (item.Estado === 'REGISTRADA'){
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