<template>
    <main-content columnClass="col-12 col-xl-10">
        <template v-slot:card-header-title>
            Tipos de Eventos
        </template>
        <template v-slot:card-header-actions>
            <button class="btn btn-sm btn-info waves-effect waves-light" @click="buscarTipoEvento()">
                <i class="fas fa-search"></i>
                <span class="d-none d-sm-inline-block">
                    Buscar
                </span>
            </button>
            <button class="btn btn-sm btn-danger waves-effect waves-light">
                <i class="fas fa-times"></i>
                <span class="d-none d-sm-inline-block" @click="limpiarFiltros()">
                    Limpiar
                </span>
            </button>
            <router-link :to="{name:'spa.tipoEvento.registrar'}" class="btn btn-sm btn-success waves-effect waves-light">
                 <i class="fas fa-plus"></i>
                <span class="d-none d-sm-inline-block ">
                    Nuevo
                </span>
            </router-link>    
        </template>
        <template v-slot:card-body-main>
            <div class="form-row">
                <div class="form-group col-12 col-sm-6 col-md-4 ">
                    <label>Tipo de Evento</label>
                    <input type="text" class="form-control" v-model="tipoevento.tipoevento" @keyup.enter="buscarTipoEvento()"> 
                </div>
                <div class="form-group col-12 col-sm-6 col-md-4 ">
                    <label>&nbsp;</label>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="estado" 
                         v-model="tipoevento.estado" @change="buscarTipoEvento()">
                        <label class="custom-control-label" for="estado">Incluir Eliminados</label>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-sm table-striped table-hover table-bordered">
                    <thead>
                        <tr>
                            <th class="p-2">Acciones</th>
                            <th class="p-2">Codigo</th>
                            <th class="p-2 text-nowrap">Tipo de Evento</th>                       
                            <th class="p-2">Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="tipoevento in tipoeventos" :key="tipoevento.idtipoevento" >
                            <td>
                                <row-actions :rowData="tipoevento" @rowItemActions="rowItemActions" :activeDelete="false">
                                    <button type="button" :title="tipoevento.isactive ? 'Desactivar':'Activar'" @click="cambiarEstado(tipoevento)"
                                            class="btn btn-sm  waves-effect waves-light border-0 mr-1"
                                            :class="tipoevento.isactive ? 'btn-outline-danger':'btn-outline-success'">
                                        <i class="fas fa-lg" :class="tipoevento.isactive ? 'fa-trash':'fa-check-circle'"></i>
                                    </button>
                                </row-actions>
                            </td>
                            <td v-text="tipoevento.idtipoevento"></td>
                            <td><span class="badge badge-pill badge-lg" v-bind:style="{background: tipoevento.backgroundColor, color:tipoevento.textColor}" v-text="tipoevento.tipoevento"></span></td>
                            <td >
                                <span class="badge badge-pill py-1 px-3" 
                                    :class="tipoevento.isactive ? 'badge-success':'badge-danger'"
                                     v-text="tipoevento.statename">
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
</template>




<script>
    import MainContent from './../../utils/MainContent';
    import PaginationLinks from './../../utils/PaginationLinks';
    import RowActions from './../../utils/RowActions';
    import 'vue2-datepicker/locale/es';

    export default {
        data() {
            return {
                tipoeventos: [],
                pagination: {},
                filters: {},
                tipoevento: {
                    tipoevento: '',
                    backgroundColor: '#d3d3d3',
                    textColor: '#000',
                    estado: false
                }
            }
        },
        
        methods: {
            listarTipoEvento() {
                showPreloader();

                let vm = this;
                axios.get(`${appApiUrl}/tipoEvento`, {
                        params: this.filters
                    })
                    .then(function (response) {

                        hidePreloader();
                        vm.tipoeventos = response.data.data;
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
                this.listarTipoEvento();
            },
            rowItemActions(event) {
                switch (event.action) {
                    case 'edit':
                        if(!event.data.isactive) {
                            warningMessage(appCannotDeleteMessage, appName);
                            break;
                        }
                        this.$router.push({ name: 'spa.tipoEvento.editar', params: { id: event.data.idtipoevento } }) 
                    break;
                    /* case 'delete':
                        this.eliminartipoEvento(event.data);
                    break; */
                }
            },
            buscarTipoEvento() {
                this.filters = {};
                this.filters.page = 1;

                if (this.tipoevento.tipoevento.length)
                    this.filters.tipoevento = this.tipoevento.tipoevento;                
                               
                if (this.tipoevento.estado)
                    this.filters.estado = this.tipoevento.estado;

                this.listarTipoEvento();  
            },
            eliminartipoEvento(param){
                let vm = this;

                if(!param.isactive) {
                    warningMessage(appRecordIsDeletedMessage, appName);
                    return;
                }

                swalAlertConfirm(`¿Seguro que quiere eliminar el Tipo de Evento <b>${param.tipoevento}</b>?`, appName)
                    .then(function(optionSelected){
                        if(optionSelected.value){
                            
                            showPreloader();
                            axios.delete(`${appApiUrl}/tipoEvento/${param.idtipoevento}`)
                                .then(function (response) {         
                                    hidePreloader();
                                    let result = response.data;

                                    if (result.status) {
                                        successMessage(result.message, appName);
                                        vm.listarTipoEvento();
                                    } else
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

            cambiarEstado(param) {
                let vm = this;
                
                let optionMessage ='Eliminar';

                if(!param.isactive) optionMessage = 'Activar';


                swalAlertConfirm(`¿Seguro que quiere ${optionMessage} El Tipo de evento <b>${param.tipoevento}</b>?`, appName)
                    .then(function (optionSelected) {

                        if (optionSelected.value) {

                            showPreloader();
                            axios.delete(`${appApiUrl}/tipoEvento/${param.idtipoevento}`)
                                .then(function (response) {
                                    hidePreloader();
                                    let result = response.data;

                                    if (result.status) {
                                        successMessage(result.message, appName);
                                        vm.listarTipoEvento();
                                    }  else if (result.warning){
                                        warningMessage(result.message, appName);
                                        vm.listarTipoEvento();
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

            limpiarFiltros(){
                this.tipoevento.tipoevento = '';
            }

        },
        mounted() {
            this.listarTipoEvento();
        },
        components: {
            MainContent,
            PaginationLinks,
            RowActions,
        }
    }

</script>
