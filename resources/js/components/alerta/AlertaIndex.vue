<template>
    <main-content>
        <!-- titulo -->
         <template v-slot:card-header-title>
            Alertas
        </template>
        <!-- acciones cabecera -->
        <template v-slot:card-header-actions>
            <button class="btn btn-sm btn-info waves-effect waves-light" @click="buscarAlerta()">
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
            <router-link :to="{name:'spa.alerta.registrar'}" class="btn btn-sm btn-success waves-effect waves-light">
                 <i class="fas fa-plus"></i>
                <span class="d-none d-sm-inline-block ">
                    Nuevo
                </span>
            </router-link>    
        </template>
        <!-- fomrulario busqueda - lista registros -->
        <template v-slot:card-body-main>
            <!-- busqueda -->
            <div class="form-row">
                <div class="form-group col-12 col-sm-6 col-md-4 ">
                    <label>Nombre Alerta</label>
                    <input type="text" class="form-control" v-model="alerta.nombrealerta" @keyup.enter="buscarAlerta">
                </div>

                 <div class="form-group col-12 col-sm-6 col-md-4 col-xl-3">
                    <label class="mb-1">Campaña</label>
                    <select2 :options="campanias" @input="buscarAlerta()" v-model="alerta.idcampania"
                        :selectValue="alerta.idcampania" placeholder="Seleccione una campaña" keyProperty="idcampania"
                        textProperty="nombrecampania">
                    </select2>
                </div>
               
                <div class="form-group col-12 col-sm-6 col-md-4 ">
                    <label>Fecha inicio-fin</label>
                    <v-date-picker v-model="alerta.fechainicio" range lang="es" format="DD-MM-YYYY" 
                        confirm :editable="false" placeholder="Seleccione un rango de fecha" @input="buscarAlerta()">
                        <template v-slot:footer="{ emit }">
                            <button class="mx-btn" @click="selectToday(emit)">
                                Today
                            </button>
                        </template>                        
                    </v-date-picker>
                </div>
                <div class="form-group col-12 col-sm-6 col-md-4 ">
                    <label>&nbsp;</label>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="estado" 
                            v-model="alerta.estado" @change="buscarAlerta()">
                        <label class="custom-control-label" for="estado">Incluir Eliminados</label>
                    </div>
                </div>
            </div>
            <!-- lista -->
            <div class="table-responsive">
                <table class="table table-sm table-striped table-hover table-bordered">
                    <thead>
                        <tr>
                            <th class="p-2">Acciones</th>
                            <th class="p-2">Codigo</th>
                            <th class="p-2">Nombre Evento</th>
                            <th class="p-2 text-nowrap">Campaña</th>
                            <th class="p-2 text-nowrap">Fecha Inicio</th>
                            <th class="p-2 text-nowrap">Hora Inicio</th>
                            <th class="p-2 text-nowrap">Fecha Fin</th>
                            <th class="p-2 text-nowrap">Hora Fin</th>
                            <th class="p-2 ">Enlace URL</th>
                            <th class="p-2">Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="alert in alertas" :key="alert.idalerta">
                            <td>
                                <row-actions :rowData="alert" @rowItemActions="rowItemActions" :activeDelete="false">
                                     <button type="button" :title="alert.isactive ? 'Desactivar':'Activar'" @click="eliminarAlerta(alert)"
                                            class="btn btn-sm  waves-effect waves-light border-0 mr-1"
                                            :class="alert.isactive ? 'btn-outline-danger':'btn-outline-success'">
                                        <i class="fas fa-lg" :class="alert.isactive ? 'fa-trash':'fa-check-circle'"></i>
                                    </button>
                                    <button type="button" title="Borrar" @click="physicallyRemove(alert)"
                                        class="btn btn-sm btn-outline-primary waves-effect waves-light border-0 mr-1">
                                        <i class="fas fa-eraser fa-lg"></i>
                                    </button>
                                </row-actions>
                            </td>
                            <td v-text="alert.idalerta"></td>
                            <td class="text-nowrap" v-text="alert.nombrealerta"></td>
                            <td class="text-nowrap" v-text="alert.campania.nombrecampania"></td>
                            <td class="text-nowrap" v-text="alert.fecharegistro"></td>
                            <td class="text-nowrap" v-text="alert.horaregistro"></td>
                            <td class="text-nowrap" v-text="alert.fechafinalizada"></td>
                            <td class="text-nowrap" v-text="alert.horafinalizada"></td>
                            <td class="ui-max-w-100 text-truncate">
                                <a TARGET="_blank" :href="alert.urlalerta"  v-text="alert.urlalerta"></a>
                            </td>
                            <td >
                                <span class="badge badge-pill py-1 px-3" 
                                    :class="alert.isactive ? 'badge-success':'badge-danger'"
                                    v-text="alert.statename">
                                </span>
                            </td>
                        </tr>
                    </tbody>

                </table>
            </div>
            <!-- paginacion -->
            <pagination-links :pagination="pagination" @changePerPage="changePerPage">
            </pagination-links>
        </template>
    </main-content>
</template>

<script>
//importamos librerias y componentes
import Select2 from './../../utils/Select2';
import MainContent from './../../utils/MainContent';
import PaginationLinks from './../../utils/PaginationLinks';
import RowActions from './../../utils/RowActions';
import VDatePicker from 'vue2-datepicker';
import 'vue2-datepicker/locale/es';
import moment,{ now, relativeTimeThreshold } from 'moment';

export default {
    data() {
        return {
            alerta:{
                nombrealerta:'',
                fechainicio: '',
                fechafin: '',
                estado: false,
                idcampania:0,
            },
            alertas:[],
            pagination: {},
            filters: {},
            campanias:[],
        }
    },

    //metodos
    methods:{
        listarAlertas() {
            showPreloader();
            let vm = this;
            axios.get(`${appApiUrl}/alerta`, {params: this.filters})
            .then(function (response) {
                hidePreloader();
                vm.alertas = response.data.data;
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
            this.listarAlertas();
        },

        rowItemActions(event) {
            switch (event.action) {
                case 'edit':
                    if(!event.data.isactive) {
                        warningMessage(appCannotDeleteMessage, appName);
                        break;
                    }

                this.$router.push({ name: 'spa.alerta.editar', params: { id: event.data.idalerta } }) 
                break;
                case 'delete':
                    this.eliminarAlerta(event.data);
                break;
            }
        },

        buscarAlerta() {
            this.filters = {};
            this.filters.page = 1;

            if (this.alerta.nombrealerta.length)
                this.filters.nombrealerta = this.alerta.nombrealerta;

            if (this.alerta.idcampania.length)
                this.filters.idcampania = this.alerta.idcampania;

            if(this.alerta.estado)
                this.filters.estado=this.alerta.estado;

            
            if(this.alerta.fechainicio.length == 2){                
                if(this.alerta.fechainicio[0] != null)
                    this.filters.fechadesde = this.formatDate(this.alerta.fechainicio[0],'DD-MM-YYYY');

                if(this.alerta.fechainicio[1] != null)
                    this.filters.fechahasta = this.formatDate(this.alerta.fechainicio[1],'DD-MM-YYYY');
            }

            this.listarAlertas();  
        },

        listarCampanias() {
            let vm = this;
            axios.get(`${appApiUrl}/campania/select`)
            .then(function (response) {
                vm.campanias = response.data;
            })
            .catch(function (error) {
                console.log(error);
            })
        },

        physicallyRemove(param) {
                let vm = this;
                swalAlertConfirm(`¿Seguro que quiere eliminar la Alerta <b>${param.nombrealerta}</b>?. Ya no tendra opcion a recuperar el registro.`, appName)
                    .then(function (optionSelected) {

                        if (optionSelected.value) {

                            showPreloader();

                            let removeParam = {
                                id: param.idalerta
                            };

                            axios.post(`${appApiUrl}/alerta/physicallyremove`, removeParam)
                                .then(function (response) {
                                    hidePreloader();
                                    let result = response.data;

                                    if (result.status) {
                                        successMessage(result.message, appName);
                                        vm.listarAlertas();
                                    }
                                    else{
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

        eliminarAlerta(param){
            let vm = this;
            let optionMessage ='Eliminar';
            if(!param.isactive) optionMessage = 'Activar';

            swalAlertConfirm(`¿Seguro que quiere ${optionMessage} el evento <b>${param.nombrealerta}</b> de la campaña <b>${param.campania.nombrecampania}</b>?`, appName)
            .then(function(optionSelected){
                if(optionSelected.value){
                    
                    showPreloader();
                    axios.delete(`${appApiUrl}/alerta/${param.idalerta}`)
                    .then(function (response) {         
                        hidePreloader();
                        let result = response.data;

                        if (result.status) {
                            successMessage(result.message, appName);
                            vm.listarAlertas();
                        } else if (result.warning){
                            warningMessage(result.message, appName);
                            vm.listarAlertas();
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
            this.alerta.nombrealerta = '';
            this.alerta.idcampania =0;
            this.buscarAlerta();
        },
        formatDate (value, fmt = 'D MMM YYYY') {
            return (value == null)
                ? ''
                : moment(value, 'YYYY-MM-DD HH:mm:ss').format(fmt)
        },
        selectToday(emit){
            emit([ new Date(), new Date() ]);
        },

    },

    //iniciamos metodos
    created(){
        this.listarAlertas();
        this.listarCampanias();
    },

    //iniciamos componentes
    components:{
        Select2,
        MainContent,
        PaginationLinks,
        RowActions,
        VDatePicker,
        moment
    },


}
</script>