<template>
    <main-content>
        <template v-slot:card-header-title>
            Carreras
        </template>
        <template v-slot:card-header-actions>
            <button class="btn btn-sm btn-info waves-effect waves-light" @click="buscarCarrera()">
                <i class="fas fa-search"></i>
                <span class="d-none d-sm-inline-block">
                    Buscar
                </span>
            </button>
            <button class="btn btn-sm btn-danger waves-effect waves-light">
                <i class="fas fa-times"></i>
                <span class="d-none d-sm-inline-block" @click="limpiarFiltrocarrera()">
                    Limpiar
                </span>
            </button>
            <router-link :to="{name:'spa.carrera.registrar'}" class="btn btn-sm btn-success waves-effect waves-light">
                 <i class="fas fa-plus"></i>
                <span class="d-none d-sm-inline-block ">
                    Nuevo
                </span>
            </router-link>    
        </template>
        <template v-slot:card-body-main>
            <div class="form-row">
                <div class="form-group col-12 col-sm-6 col-md-4 ">
                    <label>Carrera</label>
                    <input type="text" class="form-control" v-model="carrera.nombre" @keyup.enter="buscarCarrera()">
                </div>
                
                <div class="form-group col-12 col-sm-6 col-md-4 ">
                    <label>&nbsp;</label>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="estado" 
                            v-model="carrera.estado" @change="buscarCarrera()">
                        <label class="custom-control-label" for="estado">Incluir Eliminados</label>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-sm table-striped table-hover table-bordered">
                    <thead>
                        <tr>
                            <th class="p-2">Acciones</th>
                            <th class="p-2">Cod</th>
                            <th class="p-2">Carrera</th>
                            <th class="p-2">Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="carr in carreras" :key="carr.idcarrera">
                            <td>
                                <row-actions :rowData="carr" @rowItemActions="rowItemActions" :activeDelete="false">
                                    <button type="button" :title="carr.isactive ? 'Desactivar':'Activar'" @click="cambiarEstado(carr)"
                                            class="btn btn-sm  waves-effect waves-light border-0 mr-1"
                                            :class="carr.isactive ? 'btn-outline-danger':'btn-outline-success'">
                                        <i class="fas fa-lg" :class="carr.isactive ? 'fa-trash':'fa-check-circle'"></i>
                                    </button>
                                </row-actions>
                            </td>
                            <td v-text="carr.idcarrera"></td>
                            <td v-text="carr.nombre"></td>
                            <td >
                                <span class="badge badge-pill py-1 px-3" 
                                    :class="carr.isactive ? 'badge-success':'badge-danger'"
                                     v-text="carr.statename">
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
    import VDatePicker from 'vue2-datepicker';
    import 'vue2-datepicker/locale/es';
    import moment,{ now } from 'moment';

    export default {
        data() {
            return {
                carreras: [],
                pagination: {},
                filters: {},
                carrera: {
                    nombre: '',
                }
            }
        },
        
        methods: {
            listarCarrera() {
                showPreloader();

                let vm = this;
                axios.get(`${appApiUrl}/carrera`, {
                        params: this.filters
                    })
                    .then(function (response) {

                        hidePreloader();
                        vm.carreras = response.data.data;
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
                this.listarCarrera();
            },
            rowItemActions(event) {
                switch (event.action) {
                    case 'edit':
                        if(!event.data.isactive) {
                            warningMessage(appCannotDeleteMessage, appName);
                            break;
                        }

                        this.$router.push({ name: 'spa.carrera.editar', params: { id: event.data.idcarrera } }) 
                    break;
                    case 'delete':
                        this.eliminarcarrera(event.data);
                    break;
                }
            },
            buscarCarrera() {
                this.filters = {};
                this.filters.page = 1;

                if (this.carrera.nombre.length)
                    this.filters.nombre = this.carrera.nombre;

                if (this.carrera.estado)
                    this.filters.estado = this.carrera.estado;

                this.listarCarrera();  
            },
            cambiarEstado(param) {
                let vm = this;
                
                let optionMessage ='Eliminar';

                if(!param.isactive) optionMessage = 'Activar';


                swalAlertConfirm(`¿Seguro que quiere ${optionMessage} la carrera <b>${param.nombre}</b>?`, appName)
                    .then(function (optionSelected) {

                        if (optionSelected.value) {

                            showPreloader();
                            axios.delete(`${appApiUrl}/carrera/${param.idcarrera}`)
                                .then(function (response) {
                                    hidePreloader();
                                    let result = response.data;

                                    if (result.status) {
                                        successMessage(result.message, appName);
                                        vm.listarCarrera();
                                    }  else if (result.warning){
                                        warningMessage(result.message, appName);
                                        vm.listarCarrera();
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
            limpiarFiltrocarrera(){
                this.carrera.nombre = '';
                this.buscarCarrera();
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
        mounted() {
            this.listarCarrera();
        },
        components: {
            MainContent,
            PaginationLinks,
            RowActions,
            VDatePicker,
        }
    }

</script>
