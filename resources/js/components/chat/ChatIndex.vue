<template>
    <main-content>
        <template v-slot:card-header-title>
            Salas
        </template>
        <template v-slot:card-header-actions>
            <button class="btn btn-sm btn-info waves-effect waves-light" @click="buscarSala()">
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
            <router-link :to="{name:'spa.chat.registrar'}" class="btn btn-sm btn-success waves-effect waves-light">
                 <i class="fas fa-plus"></i>
                <span class="d-none d-sm-inline-block ">
                    Nuevo
                </span>
            </router-link>    
        </template>
        <template v-slot:card-body-main>
            <div class="form-row">
                <label>Esado Conexion al Servicio:</label>
                <div :class="statusConection ? 'alert-success' : 'alert-secondary' " class="alert  col-12" role="alert">
                    {{statusinfo}}
                </div>
                <div class="form-group col-12 col-sm-6 col-md-4 ">
                    <label>Nombre Sala</label>
                    <input type="text" class="form-control" v-model="sala.nombresala" @keyup.enter="buscarSala()">
                </div>

                <!-- <div class="form-group col-12 col-sm-6 col-md-4 ">
                    <label>&nbsp;</label>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="estado" 
                            v-model="sala.estado" @change="buscarSala()">
                        <label class="custom-control-label" for="estado">Incluir Eliminados</label>
                    </div>
                </div> -->
            </div>

            <div class="table-responsive">
                <table class="table table-sm table-striped table-hover table-bordered">
                    <thead>
                        <tr>
                            <th class="p-2">Acciones</th>
                            <th class="p-2">Codigo</th>
                            <th class="p-2 text-nowrap">Nombre sala</th>
                            <th class="p-2 text-nowrap">Descripción</th>
                            <th class="p-2 text-nowrap">dato fijado</th>                            
                            <th class="p-2">Tipo de Sala</th>
                            
                            <th class="p-2">Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="sls in salas" :key="sls.chat_id">
                            <td>
                                <row-actions :rowData="sls" @rowItemActions="rowItemActions" :activeDelete="false">
                                    <!-- <button type="button" :title="sls.isactive ? 'Desactivar':'Activar'" @click="cambiarEstado(sls)"
                                            class="btn btn-sm  waves-effect waves-light border-0 mr-1"
                                            :class="sls.isactive ? 'btn-outline-danger':'btn-outline-success'">
                                        <i class="fas fa-lg" :class="sls.isactive ? 'fa-trash':'fa-check-circle'"></i>
                                    </button> -->
                                    <toggle-button :labels="true" :value="!sls.isactive" @change="cambiarEstado(sls)" class="mb-0"
                                        :color="{checked: '#00c292', unchecked: '#e46a76'}">
                                        <template slot="checked">
                                            <i class="fas fa-check fa-lg" title="Activar"></i>
                                        </template>
                                        <template slot="unchecked">
                                            <i class="fas fa-trash fa-lg" title="Eliminar"></i>
                                        </template>
                                    </toggle-button> 
                                    <button type="button" title="Borrar" @click="physicallyRemove(sls)"
                                            class="btn btn-sm btn-outline-primary waves-effect waves-light border-0 mr-1">
                                            <i class="fas fa-eraser fa-lg"></i>
                                    </button>
                                </row-actions>                               
                            </td>
                            <td v-text="sls.chat_id"></td>
                            <td class="text-nowrap" v-text="sls.nombresala"></td>
                            <td class="ui-max-w-200 text-truncate" v-text="sls.descripcion"></td>
                            <td class="ui-max-w-300 text-truncate" v-text="sls.datofijado"></td>                            
                            <td v-text="sls.idtiposala"></td>                            
                            <td>
                                <span class="badge badge-pill py-1 px-3" 
                                    :class="sls.isactive ? 'badge-success':'badge-danger'"
                                    v-text="sls.statename">
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
import { ToggleButton } from 'vue-js-toggle-button';
import {socket} from './../../connectionsocket';

export default {
     data() {
        return {
            salas: [],
            pagination: {},
            filters: {},
            cuenta:[],
            sala: {
                nombresala: '',
                datofijado: '',
                descripcion: '',
                idtiposala: 1,
            },
            statusinfo: 'No se encuentra conectado actualmente al servicio',
            statusConection: false,            
        }
    },

    methods:{
        //estados connet disconnet socket.io
        actionsocketStatus(status){
            if(status){
                this.statusConection = status;
                this.statusinfo = 'Conectado con el servicio'; 
                console.log(status) 
            }else{
                console.log(status)
                this.statusConection = status;
                this.statusinfo = 'No se encuentra conectado actualmente al servicio';
            }
        },
        
        //verificamos conexion socket ´
        initsocket(){
            let vm = this;            
            if(socket.connected){
                vm.actionsocketStatus(true)
            }
            socket.on('disconnect', function(){                
                if(socket.disconnected){
                    vm.actionsocketStatus(false);
                }
            });
        }, 
        
        listarSalas() {
            showPreloader();

            let vm = this;
            axios.get(`${appApiUrl}/sala`, {
                    params: this.filters
                })
                .then(function (response) {

                    hidePreloader();
                    vm.salas = response.data.data;
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
            this.listarCampanias();
        },
        rowItemActions(event) {
            switch (event.action) {
                case 'edit':
                    if(!event.data.isactive) {
                        warningMessage(appCannotDeleteMessage, appName);
                        break;
                    }

                this.$router.push({ name: 'spa.chat.editar', params: { id: event.data.chat_id } }) 
                break;
                /* case 'delete':
                    this.cambiarEstado(event.data);
                break; */
            }
        },
        buscarSala() {
            this.filters = {};
            this.filters.page = 1;

            if (this.sala.nombresala.length)
                this.filters.nombresala = this.sala.nombresala;           

            if(this.sala.estado)
                this.filters.estado=this.sala.estado;

            this.listarSalas();  
        },

        cambiarEstado(param){
            let vm = this;                    
            showPreloader();
            axios.delete(`${appApiUrl}/sala/${param.chat_id}`)
            .then(function (response) {         
                hidePreloader();
                let result = response.data;

                if (result.status) {
                    successMessage(result.message, appName);
                    vm.listarSalas();
                    //emitimos estado sala al servicio
                    socket.emit('estado_salas_crm');
                }  else if (result.warning){
                    warningMessage(result.message, appName);
                    vm.listarSalas();
                    //emitimos estado sala al servicio
                    socket.emit('estado_salas_crm');
                } else{
                    errorMessage(result.message, appName);
                }

            })
            .catch(function (error) {
                hidePreloader();
                errorMessage(appErrorMessage, appName);
                console.log(error);
            });               
        },

        physicallyRemove(param) {
            let vm = this;
            swalAlertConfirm(`¿Seguro que quiere eliminar la sala <b>${param.nombresala}</b>?. Ya no tendra opcion a recuperar el registro.`, appName)
            .then(function (optionSelected) {

                if (optionSelected.value) {

                    showPreloader();
                    //console.log(param);
                    let removeParam = {
                        id: param.chat_id
                    };

                    axios.post(`${appApiUrl}/sala/physicallyRemove`, removeParam)
                        .then(function (response) {
                            hidePreloader();
                            let result = response.data;

                            if (result.status) {
                                successMessage(result.message, appName);
                                vm.listarSalas();
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

        limpiarFiltros(){
            this.sala.nombresala = '';
        },
    },

    created(){
        this.initsocket();
        this.listarSalas();
    },

    components:{
        MainContent,
        PaginationLinks,
        RowActions,
        ToggleButton       
    }
}
</script>