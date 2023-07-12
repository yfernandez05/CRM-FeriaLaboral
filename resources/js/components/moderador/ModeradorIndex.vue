<template>
    <div>
        <main-content colunmClass="col-12 col-md-11 col-lg-9">
            <template v-slot:card-header-title>
                Administrar Cliente
            </template>
            <template v-slot:card-header-actions>
                <button class="btn btn-sm btn-info waves-effect waves-light" @click="buscarCliente()">
                    <i class="fas fa-search"></i>
                    <span class="d-none d-sm-inline-block">
                        Buscar
                    </span>
                </button>
                <button class="btn btn-sm btn-danger waves-effect waves-light" @click="limpiarFiltros()">
                    <i class="fas fa-times"></i>
                    <span class="d-none d-sm-inline-block">
                        Limpiar
                    </span>
                </button>
                <router-link :to="{name:'spa.moderador.registrar'}" class="btn btn-sm btn-success waves-effect waves-light">
                    <i class="fas fa-plus"></i>
                    <span class="d-none d-sm-inline-block ">
                        Nuevo
                    </span>
                </router-link>   
            </template>

            <template v-slot:card-body-main>
                <div class="form-row mb-2">
                    <div class="form-group col-12 col-sm-6 col-md-4 col-xl-3">
                        <label class="mb-1">Nombres</label>
                        <input type="text" class="form-control" :disabled="validated" v-model="cliente.nombres"
                            @keyup.enter="buscarCliente" />
                    </div>

                    <div class="form-group col-12 col-sm-6 col-md-4 col-xl-3">
                        <label class="mb-1">Apellidos</label>
                        <input type="text" class="form-control" :disabled="validated" v-model="cliente.apellidos"
                            @keyup.enter="buscarCliente" />
                    </div>
                    <div class="form-group col-12 col-sm-6 col-md-4 col-xl-3">
                        <label class="mb-1">Correo</label>
                        <input type="text" class="form-control" :disabled="validated" v-model="cliente.correo" @keyup.enter="buscarCliente" />
                    </div>

                    <div class="form-group col-12 col-sm-6 col-md-4 col-xl-3">
                        <label class="mb-1">Campaña</label>
                        <select2 :options="campania" @input="buscarEvento()" v-model="cliente.idcampania"
                            :selectValue="cliente.idcampania" placeholder="Seleccione una campaña"
                            keyProperty="idcampania" textProperty="nombrecampania">
                        </select2>
                    </div>
                  
                    <div class="form-group col-12 col-sm-6 col-md-4 col-xl-3">
                        <label>&nbsp;</label>
                        <div class="custom-control custom-checkbox">
                            <input :disabled="validated" type="checkbox" class="custom-control-input" id="estado" v-model="cliente.estado"
                                @change="buscarCliente()">
                            <label class="custom-control-label" for="estado">Incluir Eliminados</label>
                        </div>
                    </div>

                </div>

                <div class="table-responsive">
                    <table class="table table-sm table-striped table-hover table-bordered">
                        <thead>
                            <tr>
                                <th class="p-2">Accion</th>
                                <th class="p-2">id</th>
                                <th class="p-2">Nombres</th>
                                <th class="p-2">Apellidos</th>
                                <th class="p-2">Email</th>          
                                <th class="p-2">Campaña</th>
                                <th class="p-2">Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="cli in clientes" :key="cli.idcliente">
                                <td>
                                    <row-actions :rowData="cli" @rowItemActions="rowItemActions" :activeEdit="false"
                                        :activeDelete="false" :activeShow="false">
                                        <button  type="button" title="Editar"  @click="editcliente(cli)"
                                        class="btn btn-sm btn-outline-success waves-effect waves-light border-0 mr-1" >
                                            <i class="fas fa-marker fa-lg"></i>
                                        </button>
                                        <button type="button" :title="cli.isactive ? 'Desactivar':'Activar'" @click="cambiarEstado(cli)"
                                             class="btn btn-sm  waves-effect waves-light border-0 mr-1"
                                             :class="cli.isactive ? 'btn-outline-danger':'btn-outline-success'">
                                            <i class="fas fa-lg" :class="cli.isactive ? 'fa-trash':'fa-check-circle'"></i>
                                        </button>
                                        <button type="button" title="Borrar" @click="physicallyRemove(cli)"
                                            class="btn btn-sm btn-outline-primary waves-effect waves-light border-0 mr-1">
                                            <i class="fas fa-eraser fa-lg"></i>
                                        </button>

                                    </row-actions>
                                </td>
                                <td v-text="cli.idcliente"></td>
                                <td v-text="cli.nombres" class="ui-max-w-300 text-truncate"></td>
                                <td v-text="cli.apellidos" class="ui-max-w-300 text-truncate"></td>
                                <td v-text="cli.email"></td>                                                             
                                <td v-text="cli.campania.nombrecampania" class="ui-max-w-200 text-truncate"></td>
                                <td>
                                    <span class="badge badge-pill py-1 px-3"
                                        :class="cli.isactive ? 'badge-success':'badge-danger'" v-text="cli.statename">
                                    </span>
                                </td>

                            </tr>
                        </tbody>
                    </table>
                </div>
                <pagination-links :pagination="pagination" @changePerPage="changePerPage">
                </pagination-links>
            </template>
        </main-content>
    </div>
</template>


<script>
    import MainContent from './../../utils/MainContent';
    import PaginationLinks from './../../utils/PaginationLinks';
    import Select2 from './../../utils/Select2';
    import RowActions from './../../utils/RowActions';
    import 'vue2-datepicker/locale/es';

    export default {
        data() {
            return {

                cliente: {
                    nombres: '',
                    apellidos: '',
                    dni: '',
                    telefono: '',
                    correo: '',
                    fecharegistro: '',
                    estado: false,
                    coddistrito: 0,
                    idcampania: 0,
                    idevento: 0,
                    procedencia: '',
                },
                clientes: [],
                filters: {},
                pagination: {},
                campania: [],
                eventos: [],
                distrito: [],
                procedencias: [],
                validated : false,
            }

        },
        methods: {
            listarCliente() {
                showPreloader();

                let vm = this;
                axios.get(`${appApiUrl}/moderador`, {
                        params: this.filters
                    })
                    .then(function (response) {

                        hidePreloader();
                        vm.clientes = response.data.data;
                        vm.pagination = response.data;
                        delete vm.pagination.data;
                    })
                    .catch(function (error) {
                        hidePreloader();
                        console.log(error);
                    });
            },
            changePerPage(event) {
                this.filters.page = event.page;
                this.filters.perpage = event.perpage;

                this.listarCliente();
            },
            buscarCliente() {
                this.addFiltersRole();
                this.listarCliente();
            },

            listarCampania() {
                let vm = this;
                axios.get(`${appApiUrl}/campania/select`)
                    .then(function (response) {
                        vm.campania = response.data;
                    })
                    .catch(function (error) {
                        console.log(error);
                    })
            },

            limpiarFiltros() {

                this.cliente.nombres = '';
                this.cliente.apellidos = '';               
                this.cliente.correo = '';
                this.cliente.idcampania = 0;
                this.buscarCliente();

            },

            rowItemActions(event) {
                switch (event.action) {
                    case 'show':
                        this.$nextTick(() => {
                            this.$refs.modalAtencion.showDetail(event.data);
                        });
                        break;
                    /* case 'edit':
                       this.$router.push({ name: 'spa.administrarcliente.editar', params: { id: event.data.idcliente } }) 
                   break; */
                    // case 'delete':
                    //     this.cambiarEstado(event.data);
                    //     break;
                }

            },

            editcliente(event){
                this.$router.push({ name: 'spa.moderador.editar', params: { id: event.idcliente } }) 
                console.log(event);
            },
            cambiarEstado(param) {
                let vm = this;
                 let optionMessage ='Eliminar';

                if(!param.isactive) optionMessage = 'Activar';

                swalAlertConfirm(`¿Seguro que quiere ${optionMessage} El Moderador <b>${param.nombres}</b>?`, appName)
                    .then(function (optionSelected) {

                        if (optionSelected.value) {

                            showPreloader();
                            axios.delete(`${appApiUrl}/moderador/${param.idcliente}`)
                                .then(function (response) {
                                    hidePreloader();
                                    let result = response.data;

                                    if (result.status) {
                                        successMessage(result.message, appName);
                                        vm.listarCliente();
                                    } else if (result.warning){
                                        warningMessage(result.message, appName);
                                        vm.listarCliente();
                                    } else{
                                        errorMessage(result.message, appName);
                                    }

                                })
                                .catch(function (error) {
                                    hidePreloader();
                                    errorMessage(appErrorMessage, appName);
                                    console.log(error);
                                });
                        }


                    });
            },
            physicallyRemove(param) {
                let vm = this;
                swalAlertConfirm(`¿Seguro que quiere eliminar Moderador <b>${param.nombres}</b>?. Ya no tendra opcion a recuperar el registro.`, appName)
                    .then(function (optionSelected) {

                        if (optionSelected.value) {

                            showPreloader();

                            let removeParam = {
                                id: param.idcliente
                            };

                            axios.post(`${appApiUrl}/moderador/physicallyremove`, removeParam)
                                .then(function (response) {
                                    hidePreloader();
                                    let result = response.data;

                                    if (result.status) {
                                        successMessage(result.message, appName);
                                        vm.listarCliente();
                                    } else if (result.warning)
                                        warningMessage(result.message, appName);
                                    else
                                        errorMessage(result.message, appName);
                                })
                                .catch(function (error) {
                                    hidePreloader();
                                    errorMessage(appErrorMessage, appName);
                                    console.log(error);
                                });
                        }


                    });
            },
            addFiltersRole() {
                this.filters = {};
                this.filters.page = 1;

                if (this.cliente.nombres.length)
                    this.filters.nombres = this.cliente.nombres;

                if (this.cliente.apellidos.length)
                    this.filters.apellidos = this.cliente.apellidos;
                
                if (this.cliente.correo.length)
                    this.filters.email = this.cliente.correo;    

                if (this.cliente.idcampania.length)
                    this.filters.idcampania = this.cliente.idcampania;                

                if (this.cliente.estado)
                    this.filters.estado = this.cliente.estado;
            },

        },
        mounted() {
            this.listarCliente();
            this.listarCampania();
        },

        components: {
            MainContent,
            PaginationLinks,
            Select2,
            RowActions,
        },
    }

</script>
