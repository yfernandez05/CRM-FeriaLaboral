<template>
     <main-content columnClass="col-12 col-md-11 col-lg-9">
        <template v-slot:card-header-title>
            Conexion Chat
        </template>
        <template v-slot:card-body-main>
            <div class="form-row">
                <label>Esado Conexion al Servicio:</label>
                <div :class="statusConection ? 'alert-success' : 'alert-secondary' " class="alert  col-12" role="alert">
                    {{statusinfo}}
                </div>
            </div>            

            <div class="table-responsive">
                <table class="table table-sm table-striped table-hover table-bordered">
                    <thead>
                        <tr>

                            <th class="p-2">Acciones</th>
                            <th class="p-2">Codigo</th>
                            <th class="p-2">Nombre</th>
                            <th class="p-2">Descripción</th>
                            <th class="p-2">Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="conn in conexiones" :key="conn.idconexion">
                            <td>
                                <row-actions :rowData="conn" @rowItemActions="rowItemActions" :activeDelete="false" :activeEdit="false">
                                    <toggle-button :labels="true" :value="!conn.isactive" @change="cambiarEstado(conn)" class="mb-0"
                                        :color="{checked: '#00c292', unchecked: '#e46a76'}">
                                        <template slot="checked">
                                            <i class="fas fa-check fa-lg" title="Activar"></i>
                                        </template>
                                        <template slot="unchecked">
                                            <i class="fas fa-trash fa-lg" title="Eliminar"></i>
                                        </template>
                                    </toggle-button>  
                                </row-actions>
                            </td>
                            <td v-text="conn.idconexion"></td>
                            <td v-text="conn.nombre"></td>
                            <td v-text="conn.descripcion"></td>
                            <td>
                                <span class="badge badge-pill py-1 px-3" 
                                    :class="conn.isactive ? 'badge-success':'badge-danger'"
                                     v-text="conn.statename">
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
        return{
            conexion:{},
            conexiones:[],
            pagination: {},
            filters: {},
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


        listarConexion() {
            showPreloader();

            let vm = this;
            axios.get(`${appApiUrl}/conexionsocket`, {
                    params: this.filters
                })
                .then(function (response) {

                    hidePreloader();
                    vm.conexiones = response.data.data;
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
            this.listarConexion();
        },
        rowItemActions(event) {
            switch (event.action) {
                case 'edit':
                    this.$router.push({ name: 'spa.conexion.editar', params: { id: event.data.idconexion } }) 
                break;
            }
        },
        buscarConexion() {
            this.filters = {};
            this.filters.page = 1;

            if (this.conexion.nombre.length)
                this.filters.nombre = this.conexion.nombre;

            if (this.conexion.estado)
                this.filters.estado = this.conexion.estado;    

            this.listarConexion();  
        },

        //enviamos status conexion al server
        sendStatusConnection(){
            socket.emit('update_status_conection_crm');
        },

        cambiarEstado(param){
            let vm = this;
            
            showPreloader();
            axios.delete(`${appApiUrl}/conexionsocket/${param.idconexion}`)
            .then(function (response) {         
                hidePreloader();
                let result = response.data;

                if (result.status) {
                    //densstatus socket server
                    vm.sendStatusConnection();

                    successMessage(result.message, appName);
                    vm.listarConexion();
                } else
                    errorMessage(result.message, appName);
                    vm.listarConexion();
            })
            .catch(function (error) {
                hidePreloader();
                errorMessage(appErrorMessage, appName);
                vm.listarConexion();
                console.log(error);
            });

        },
            
        limpiarFiltros(){
            this.conexion.nombre = '';
        }
    },

    created(){
        console.log('iniciado');
        this.initsocket();
        this.listarConexion();
    },

    components:{
        PaginationLinks,
        MainContent,        
        RowActions,
        ToggleButton
    }
}
</script>