<template>
    <!-- Contenedor principal -->
    <main-content>
        <!-- titulo -->
        <template v-slot:card-header-title>
            Invitaciones 
        </template>
        <!-- Acciones header -->
        <template v-slot:card-header-actions>
            <button class="btn btn-sm btn-info waves-effect waves-light" @click="buscarInvitacion()">
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
            <router-link :to="{name:'spa.invitacion.registrar'}" class="btn btn-sm btn-success waves-effect waves-light">
                 <i class="fas fa-plus"></i>
                <span class="d-none d-sm-inline-block ">
                    Nuevo
                </span>
            </router-link>    
        </template>
        <template v-slot:card-body-main>
            <!-- Fomrulario busqueda -->
            <div class="form-row">
                <div class="form-group col-12 col-sm-6 col-md-4 col-xl-3">
                    <label>Institucion</label>
                    <input type="text" class="form-control" v-model="invitacion.nombreinstitucion" @keyup.enter="buscarInvitacion()">
                </div>
                <div class="form-group col-12 col-sm-6 col-md-4 col-xl-3">
                    <label>Encargado</label>
                    <input type="text" class="form-control" v-model="invitacion.nombreencargado" @keyup.enter="buscarInvitacion()">
                </div>
                <!-- <div class="form-group col-12 col-sm-6 col-md-4 col-xl-3">
                    <label class="mb-1">Asesor</label>
                    <select2 :options="distritos"  @input="buscarInstitucion" v-model="institucion.coddistrito"
                        :selectValue="institucion.coddistrito" placeholder="Seleccione una Distrito"
                        keyProperty="coddistrito" textProperty="distrito">
                    </select2>                    
                </div> -->
                
                <div class="form-group col-12 col-sm-6 col-md-4 col-xl-3">
                    <label class="mb-1">Asesor </label>
                    <select2 :options="users" v-model="invitacion.iduser" @input="buscarInvitacion" 
                        :selectValue="invitacion.iduser" placeholder="Seleccione un Asesor"
                        keyProperty="id" textProperty="name">
                    </select2>
                </div>
                <div class="form-group col-12 col-sm-6 col-md-4 col-xl-3">
                    <label>&nbsp;</label>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="estado" 
                            v-model="invitacion.estado" @change="buscarInvitacion()">
                        <label class="custom-control-label" for="estado">Incluir Eliminados</label>
                    </div>
                </div>
            </div>
            <!-- Tabla -->
            <div class="table-responsive">
                <table class="table table-sm table-striped table-hover table-bordered">
                    <thead>
                        <tr>
                            <th class="p-2">Acciones</th>
                            <th class="p-2">Cod</th>                            
                            <th class="p-2 text-nowrap">Institucion</th>
                            <th class="p-2 text-nowrap">Encargado</th>
                            <th class="p-2 text-nowrap">F. Invitacion</th>
                            <th class="p-2 text-nowrap">Asesor Generado</th>
                            <!-- <th class="p-2 text-nowrap">Tipo Invi. Generado</th> -->
                            <th class="p-2 text-nowrap">Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="inv in invitaciones" :key="inv.idinvitacion">
                            <td>
                                <row-actions :rowData="inv" @rowItemActions="rowItemActions" :activeDelete="false">
                                    <button type="button" :title="inv.isactive ? 'Desactivar':'Activar'" @click="eliminarInvitacion(inv)" 
                                        class="btn btn-sm  waves-effect waves-light border-0 mr-1" :class="inv.isactive ? 'btn-outline-danger':'btn-outline-success'">
                                        <i class="fas fa-lg" :class="inv.isactive ? 'fa-trash':'fa-check-circle'"></i>
                                    </button>
                                    <button type="button" title="Invitacion Brochure" @click="generarinvitacion(inv)" 
                                        class="btn btn-sm  waves-effect waves-light border-0 mr-1 btn-outline-warning">
                                        <i class="far fa-lg fa-file-pdf"></i>
                                    </button>
                                </row-actions>                                
                            </td>
                            <td v-text="inv.idinvitacion" class="ui-max-w-300 text-truncate"></td>                            
                            <td v-text="inv.nombreinstitucion" class="ui-max-w-300 text-truncate"></td>                            
                            <td v-text="inv.nombreencargado" class="ui-max-w-300 text-truncate"></td>
                            <td v-text="inv.fecha" class="ui-max-w-300 text-truncate"></td>
                            <td v-text="inv.user.name" class="ui-max-w-300 text-truncate"></td>
                            <!-- <td v-if="inv.idinstitucion" class="ui-max-w-300 text-truncate">{{inv.idinstitucion}}</td><td v-else>Invitacion Externo</td> -->
                            <td>
                                <span class="badge badge-pill py-1 px-3" :class="inv.isactive ? 'badge-success':'badge-danger'"  v-text="inv.statename">
                                </span>
                            </td>                            
                        </tr>
                    </tbody>

                </table>
            </div>
            <!-- Paginacion -->
            <pagination-links :pagination="pagination" @changePerPage="changePerPage">
            </pagination-links>
        </template>
    </main-content>
</template>

<script>
//importamos librerias o utlierias
import MainContent from './../../utils/MainContent';
import PaginationLinks from './../../utils/PaginationLinks';
import RowActions from './../../utils/RowActions';
import Select2 from './../../utils/Select2';

export default {
    data() {
        return{
            invitacion:{
                nombreinstitucion:'',
                nombreencargado:'',
                fecharegistro:'',
                iduser:0,
            },
            invitaciones:[],
            users:[],
            pagination: {},
            filters: {},
        }    
    },

    methods:{
        listarInvitacion(){
            showPreloader();
            let vm = this;
            axios.get(`${appApiUrl}/invitacion`, {params: this.filters})
            .then(function (response){
                hidePreloader();
                vm.invitaciones = response.data.data;
                vm.pagination = response.data;
                delete vm.pagination.data;
            })
            .catch(function (error){
                hidePreloader();
                console.log(error);
            })
        },
        listarUser() {
            let vm = this;
            axios.get(`${appApiUrl}/user/userasesor`)
            .then(function (response) {

                hidePreloader();
                vm.users = response.data;

            })
            .catch(function (error) {
                hidePreloader();
                console.log(error);
            });
        },

         changePerPage(event) {
            this.filters.page = event.page;
            this.filters.perpage = event.perpage;
            this.listarInvitacion();
        },

        buscarInvitacion(){
            this.filters = {};
            this.filters.page = 1;

            if (this.invitacion.nombreinstitucion.length)
                this.filters.nombreinstitucion = this.invitacion.nombreinstitucion;

            if (this.invitacion.nombreencargado.length)
                this.filters.nombreencargado = this.invitacion.nombreencargado;

            if (this.invitacion.iduser.length)
                this.filters.iduser = this.invitacion.iduser;

            if (this.invitacion.estado)
                this.filters.estado = this.invitacion.estado;

            this.listarInvitacion();
        },

        limpiarFiltros(){
            this.institucion= {
                nombreinstitucion: '',
                nombreencargado: '',
                estado: false,
                iduser: 0,
            }
            this.buscarInvitacion();
        },

        rowItemActions(event) {
            switch (event.action) {
                case 'edit':
                    if(!event.data.isactive) {
                        warningMessage(appCannotDeleteMessage, appName);
                        break;
                    }
                    this.$router.push({ name: 'spa.invitacion.editar', params: { id: event.data.idinvitacion } }) 
                break;
                /* case 'delete':
                    this.eliminarInvitacion (event.data);
                break; */
            }
        },

        eliminarInvitacion(param){
            let vm = this;
           /*  if(!param.isactive) {
                warningMessage(appRecordIsDeletedMessage, appName);
                return;
            } */
            let optionMessage ='Eliminar';
            if(!param.isactive) optionMessage = 'Activar';

            swalAlertConfirm(`¿Seguro que quiere ${optionMessage} la invitacion de la institución <b>${param.nombreinstitucion}</b>?`, appName)
            .then(function(optionSelected){
                if(optionSelected.value){
                    
                    showPreloader();
                    axios.delete(`${appApiUrl}/invitacion/${param.idinvitacion}`)
                    .then(function (response) {         
                        hidePreloader();
                        let result = response.data;

                        if (result.status) {
                            successMessage(result.message, appName);
                            vm.listarInvitacion();
                        } else if (result.warning){
                            warningMessage(result.message, appName);
                            vm.listarInvitacion();
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

        generarinvitacion(data){
            console.log(data);
            let urlPdf = `${appApiUrl}/invitacion/brochure/${data.idinvitacion}`;
            //let urlPdf = `${appApiUrl}/invitacion/brochure`;
            window.open(urlPdf,'_blank')
        },

    },


    created(){
        this.listarInvitacion();
        this.listarUser();
    },

    components:{
        MainContent,
        PaginationLinks,
        RowActions,
        Select2
    }
}
</script>